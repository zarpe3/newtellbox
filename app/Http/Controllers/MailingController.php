<?php

namespace App\Http\Controllers;

use App\Actions\Customer\MailingAction;
use Illuminate\Http\Request;
use Auth;

class MailingController extends Controller
{
    public function index()
    {
        return view('mailing.index');
    }

    public function create()
    {
        return view('mailing.add');
    }
    public function dataTable()
    {
        $customer = Auth::user()->customer;
        $response = (new MailingAction())->execute($customer, [
            'action' => 'getdata',
        ]);
        return $response;
    }
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
            'mailing' => $request->file('file'),
            'valid_cpf' =>  $request->valid_cpf ?? '1',
            'campaign_name' => $request->campaign_name ?? 'padrão'
        ]);
        return $response;
    }
}
