<?php

namespace App\Http\Controllers;

use App\Actions\Customer\MailingAction;
use Illuminate\Http\Request;
use Auth;

class MailingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $customer = Auth::user()->customer;
        $response = (new MailingAction())->execute($customer, [
            'action' => 'import',
            'mailing' => $request->file('mailing'),
            'valid_cpf' =>  $request->valid_cpf ?? '1',
        ]);
        return $response;
    }
}
