<?php

namespace App\Http\Controllers\Asterisk;

use App\Http\Controllers\Controller;
use App\Actions\Asterisk\API\AGI;
use Illuminate\Http\Request;

class AGIController extends Controller
{
    //
    public function getAccountCode(Request $request)
    {
        return (new AGI())->execute(['request' => 'getAccountCode','callerid' => $request->callerid]);
    }

    public function getExtens(Request $request)
    {
        return (new AGI())->execute([
            'request' => 'getExtens',
            'accountcode' => $request->accountcode
        ]);
    }

    public function getTrunk(Request $request) {
        return (new AGI())->execute([
            'request' => 'getTrunk',
            'callerid' => $request->callerid,
            'accountcode' => $request->accountcode,
            'ddd' => $request->ddd,
            'type' => $request->type
        ]);
    }

    public function rating(Request $request) {
        return (new AGI())->execute([
            'request' => 'rating',
            'src' => $request->src,
            'dst' => $request->dst,
            'accountCode' => $request->accountCode,
            'answerTime' => $request->answerTime,
            'billsec' => $request->billsec
        ]);
    }

    public function cdr(Request $request) {
        return (new AGI())->execute(array_merge($request->all(), ['request' => 'cdr']));
    }
}
