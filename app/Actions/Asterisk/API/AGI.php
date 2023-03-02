<?php

namespace App\Actions\Asterisk\API;

use App\Actions\ActionBase;
use App\Actions\Asterisk\Inbound\GetInbound;
use App\Actions\Asterisk\Queue\GetQueue;
use App\Actions\CGrates\Connect;
use App\Models\CDR;
use App\Models\Customer;
use App\Models\SipRoutes as OutboundRoute;
use App\Models\SipUsers;
use Illuminate\Support\Facades\Http;

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
            'rating' => $this->data['rating'],
        ]);

        if (isset($this->data['recording'])) {
            Storage::disk('local')->makeDirectory('storage/app/'.$this->data['accountCode'], 0777);
            $this->data['recording']->storeAs($this->data['accountCode'], $this->data['uniqueid'].'.wav');
        }
    }

    private function getRating()
    {
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
        return Http::post('http://webdec-dev03.webdec.com.br/trunks/list', [
                'accountcode' => $accountcode,
        ]);
    }
}
