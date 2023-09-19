<?php

namespace App\Actions\Asterisk\API;

use App\Actions\ActionBase;
use App\Actions\Asterisk\Inbound\GetInbound;
use App\Actions\Asterisk\Queue\GetQueue;
use App\Actions\CGrates\Connect;
use App\Actions\Customer\IVR\ListIVR;
use App\Actions\Customer\Mailing\ScheduleMailing;
use App\Models\CDR;
use App\Models\Customer;
use App\Models\Mailing as Phones;
use App\Models\MailingFollowUp;
use App\Models\SipRoutes as OutboundRoute;
use App\Models\SipUsers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class AGI
{
    use ActionBase;
    use Connect;

    public function setParameters(array $data): void
    {
        $this->data = $data;
    }

    protected function main()
    {
        return $this->{$this->data['request']}();
    }

    private function cdr()
    {
        CDR::create([
            'accountCode' => $this->data['accountCode'],
            'src' => $this->data['src'],
            'dst' => $this->data['dst'],
            'start_date' => date('Y-m-d H:i:s', substr($this->data['start_date'], 0, 10)),
            'end_date' => date('Y-m-d H:i:s', substr($this->data['end_date'], 0, 10)),
            'status' => $this->data['status'],
            'uniqueid' => $this->data['uniqueid'],
            'billsec' => intval($this->data['billsec']),
            'rating' => 0,
        ]);

        if (isset($this->data['recording'])) {
            if (!Storage::disk('local')->exists('storage/app/'.$this->data['accountCode'])) {
                Storage::disk('local')->makeDirectory('storage/app/'.$this->data['accountCode'], 0777);
            }

            $this->data['recording']->storeAs($this->data['accountCode'], $this->data['uniqueid'].'.wav');
        }
    }

    private function rating()
    {
        return response()->json(['success' => false, 'message' => 'cgrares is out']);

        return $response = $this->sendDataToCGRates(['method' => 'APIerSv1.GetCost', 'params' => [[
            'Tenant' => $this->data['accountCode'],
            'Category' => 'call',
            'Subject' => $this->data['src'],
            'AnswerTime' => $this->data['answerTime'],
            'Destination' => $this->data['dst'],
            'Usage' => $this->data['billsec'],
        ]], 'id' => 0]);
    }

    private function getAccountCode()
    {
        return response()->json([
            'success' => true,
            'accountcode' => SipUsers::where('name', $this->data['callerid'])->first()->accountcode,
        ]);
    }

    private function getExtens()
    {
        return response()->json([
            'success' => true,
            'extens' => SipUsers::where('accountcode', $this->data['accountcode'])->get(['name', 'record']),
        ]);
    }

    private function getTrunk()
    {
        $type = 'fixo';
        if ($this->data['type'] == 'MOBILE') {
            $type = 'celular';
        }

        $contextTo = SipUsers::where('accountcode', $this->data['accountcode'])
            ->where('name', $this->data['accountcode'].$this->data['callerid'])
            ->get(['context_to'])
            ->first();

        $routes = OutboundRoute::accountcode($this->data['accountcode'])
            ->where('ddd', $this->data['ddd'])
            ->where('name', $contextTo->context_to)
            ->where('type', $type);

        if (!$routes->exists()) {
            return response()->json([
                'success' => false,
                'msg' => 'No routes available',
            ]);
        }

        $trunkName = $routes->get(['trunk'])->first()->trunk;
        $response = $this->getTrunksByAccount($this->data['accountcode']);

        $trunk = $response['response'][$trunkName.'_'.$this->data['accountcode']];

        return response()->json([
            'success' => true,
            'trunk' => $trunk,
        ]);
    }

    private function getInbound()
    {
        try {
            $customer = Customer::getAccountCode($this->data['accountcode'])->firstOrFail();

            if (!$customer) {
                return response()->json([
                    'success' => false,
                ]);
            }

            $inbound = (new GetInbound())->execute($customer, ['did' => $this->data['did']]);

            if (count($inbound) > 0) {
                return response()->json([
                    'success' => true,
                    'inbound' => $inbound,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No DID found',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function getQueue()
    {
        try {
            $customer = Customer::getAccountCode($this->data['accountcode'])->firstOrFail();

            if (!$customer) {
                return response()->json([
                    'success' => false,
                ]);
            }

            $queue = (new GetQueue())->execute($customer, ['name' => $this->data['name']]);

            if (is_object($queue)) {
                return response()->json([
                    'success' => true,
                    'queue' => $queue,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No Queue found',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function getTrunksByAccount($accountcode)
    {
        return Http::post('https://webdec-dev03.webdec.com.br/trunks/list', [
                'accountcode' => $accountcode,
        ]);
    }

    private function getIVR()
    {
        $customer = Customer::getAccountCode($this->data['accountcode'])->firstOrFail();

        return (new ListIVR())->execute($customer, ['id' => $this->data['id']]);
    }

    private function getTrunkFromDialer()
    {
        $mailing = MailingFollowUp::where('_id', $this->data['campaign_id'])->first();

        if (!$mailing) {
            return ['match' => 0];
        }

        $customer = Customer::find($mailing->customer_id);

        if (!$customer) {
            return ['match' => 0];
        }

        $type = 'fixo';
        if ($this->data['type'] == 'MOBILE') {
            $type = 'celular';
        }

        //\Log::info('Looking for '.$mailing->route.' DDD '.$this->data['ddd'].' and type '.$type);
        $trunkName = OutboundRoute::accountCode($customer->accountcode)
            ->name($mailing->route)
            ->where('ddd', $this->data['ddd'])
            ->where('type', $type)
            ->first();

        if (!$trunkName) {
            return ['match' => 0];
        }

        $response = $this->getTrunksByAccount($customer->accountcode);
        $trunk = $response['response'][$trunkName->trunk.'_'.$customer->accountcode];

        return ['match' => 1, 'trunk' => $trunk, 'accountCode' => $customer->accountcode];
    }

    private function getAmdFromDialer()
    {
        $mailing = MailingFollowUp::where('_id', $this->data['campaign_id'])->first();

        if (!$mailing) {
            return ['success' => false];
        }

        $customer = Customer::find($mailing->customer_id);

        return ['success' => true, 'amd' => $mailing->amd, 'accountCode' => $customer->accountcode, 'timeout' => $mailing->timeout];
    }

    private function hangup()
    {
        $schedule = (new ScheduleMailing())->execute(['dialstatus' => $this->data['dialstatus']]);
        $mailings = Phones::where('_id', $this->data['customer_id'])->get();

        foreach ($mailings as $m) {
            $id = $m->_id;
            $phones = $m->phones;

            foreach ($phones as &$phone) {
                if ($phone['phone'] === $this->data['phone']) {
                    $phone['status'] = $schedule['status'];
                    $phone['schedule'] = $schedule['schedule'];
                }
            }

            Phones::where('_id', $this->data['customer_id'])
                //->where('phones.status', '=', 100)
                ->update([
                    'phones' => $phones,
                    'status' => $schedule['status'],
                ]);
        }
    }
}
