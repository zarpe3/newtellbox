<?php

namespace App\Http\Controllers;

use App\Actions\Customer\MailingAction;
use App\Models\MailingFollowUp;
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
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $customer = Auth::user();
        $response = (new MailingAction())->execute($customer->customer, [
            'action' => 'import',
            'user_id' => $customer->id,
            'customer_id' => $customer->customer->id,
            'mailing' => $request->file('file'),
            'valid_cpf' =>  $request->valid_cpf ?? '1',
            'campaign_name' => $request->campaign_name ?? 'padrão'
        ]);
        return $response;
    }

    public function exportError(Request $request)
    {
        $customer = Auth::user();
        $response = (new MailingAction())->execute($customer->customer, [
            'action' => 'export-error',
        ]);
        return $response;
    }

    public function followUp(Request $request)
    {
        $customer = Auth::user();
        $response = (new MailingAction())->execute($customer->customer, [
            'action' => 'GET',
        ]);
        return $response;
    }
}
