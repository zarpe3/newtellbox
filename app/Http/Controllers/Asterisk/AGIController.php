<?php

namespace App\Http\Controllers\Asterisk;

use App\Http\Controllers\Controller;
use App\Actions\Asterisk\API\AGI;
use Illuminate\Http\Request;

class AGIController extends Controller
{
    public function getAccountCode(Request $request)
    {
        return (new AGI())->execute(['request' => 'getAccountCode', 'callerid' => $request->callerid]);
    }

    public function getExtens(Request $request)
    {
        return (new AGI())->execute([
            'request' => 'getExtens',
            'accountcode' => $request->accountcode,
        ]);
    }

    public function getTrunk(Request $request)
    {
        return (new AGI())->execute([
            'request' => 'getTrunk',
            'callerid' => $request->callerid,
            'accountcode' => $request->accountcode,
            'ddd' => $request->ddd,
            'type' => $request->type,
        ]);
    }

    public function rating(Request $request)
    {
        return (new AGI())->execute([
            'request' => 'rating',
            'src' => $request->src,
            'dst' => $request->dst,
            'accountCode' => $request->accountCode,
            'answerTime' => $request->answerTime,
            'billsec' => $request->billsec,
        ]);
    }

    public function cdr(Request $request)
    {
        $options = ['request' => 'cdr'];

        if ($request->file('recording')) {
            $options['file'] = $request->file('recording');
        }

        return (new AGI())->execute(array_merge($request->all(), $options));
    }

    public function getInbound(Request $request)
    {
        return (new AGI())->execute([
            'request' => 'getInbound',
            'accountcode' => $request->accountcode,
            'did' => $request->did,
        ]);
    }

    public function queue(AGI $agi, Request $request)
    {
        return $agi->execute([
            'request' => 'getQueue',
            'accountcode' => $request->accountcode,
            'name' => $request->name,
        ]);
    }

    public function getIVR(AGI $agi, Request $request)
    {
        return $agi->execute([
            'request' => 'getIVR',
            'accountcode' => $request->accountcode,
            'id' => $request->id,
        ]);
    }

    public function getTrunkFromDialer(AGI $agi, Request $request)
    {
        return $agi->execute([
            'request' => 'getTrunkFromDialer',
            'customer_id' => $request->customer_id,
            'campaign_id' => $request->campaign_id,
            'ddd' => $request->ddd,
            'type' => $request->type,
        ]);
    }

    public function getAmdFromDialer(AGI $agi, Request $request)
    {
        return $agi->execute([
            'request' => 'getAmdFromDialer',
            'campaign_id' => $request->campaign_id,
        ]);
    }

    public function hangup(AGI $agi, Request $request)
    {
        return $agi->execute([
            'request' => 'hangup',
            'customer_id' => $request->customer_id,
            'phone' => $request->phone,
            'dialstatus' => $request->dialstatus,
        ]);
    }
}
