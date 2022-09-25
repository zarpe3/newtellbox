<?php

namespace App\Actions\Asterisk\API;

use App\Actions\ActionBase;
use App\Actions\CGrates\Connect;
use App\Models\SipUsers;
use App\Models\CDR;
use App\Models\SipRoutes as OutboundRoute;
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
        if ($this->data['request'] == 'cdr') {
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
        }

        if ($this->data['request'] == 'rating') {
            return $response = $this->sendDataToCGRates(['method' => 'APIerSv1.GetCost', 'params' => [[
                    'Tenant' => $this->data['accountCode'],
                    'Category' => 'call',
                    'Subject' => $this->data['src'],
                    'AnswerTime' => $this->data['answerTime'],
                    'Destination' => $this->data['dst'],
                    'Usage' => $this->data['billsec'],
                    ]], 'id' => 0]);
        }

        if ($this->data['request'] == 'getAccountCode') {
            return response()->json([
                    'success' => true,
                    'accountcode' => SipUsers::where('name', $this->data['callerid'])->first()->accountcode,
            ]);
        }

        if ($this->data['request'] == 'getExtens') {
            return response()->json([
                    'success' => true,
                    'extens' => SipUsers::where('accountcode', $this->data['accountcode'])->get(['name']),
            ]);
        }

        if ($this->data['request'] == 'getTrunk') {
            $type = 'fixo';
            if ($this->data['type'] == 'MOBILE') {
                $type = 'celular';
            }

            $contextTo = SipUsers::where('accountcode', $this->data['accountcode'])
                ->where('name', $this->data['accountcode'].$this->data['callerid'])
                ->get(['context_to'])
                ->first();

            $routes = OutboundRoute::where('ddd', $this->data['ddd'])
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
    }

    private function getTrunksByAccount($accountcode)
    {
        return Http::post('http://webdec-dev03.webdec.com.br/trunks/list', [
                'accountcode' => $accountcode,
        ]);
    }
}
