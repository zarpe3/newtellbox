<?php

namespace App\Actions\CGrates;

use Illuminate\Support\Facades\Http;
use Auth;

trait Connect
{
    public function sendDataToCGRates(array $data)
    {
        //$accountcode = Auth::user()->customer->accountcode;
        //dump(json_encode(['method' => 'ApierV2.Pings','params'=> [["Tenant" => "webdec"]]]));
        Http::withHeaders([
            'Content-type' => 'application/json',
            'Accept' => 'text/plain',
        ])->send('POST', 'http://10.124.0.6:2080/jsonrpc', [
            'body' => json_encode(['method' => 'ApierV2.Pings', 'params' => [['Tenant' => 'webdec']]]),
        ])->json();

        //dump(json_encode($data));
        return $response = Http::withHeaders([
            'Content-type' => 'application/json',
            'Accept' => 'text/plain',
        ])->send('POST', 'http://10.124.0.6:2080/jsonrpc', [
            'body' => json_encode($data),
        ])->json();
    }
}
