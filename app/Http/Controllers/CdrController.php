<?php

namespace App\Http\Controllers;

use App\Actions\Customer\GetCDR;
use App\Http\Requests\CdrRequest;
use Auth;

class CdrController extends Controller
{
    /**
     * Display a listing of the customers.
     *
     * @param \App\Models\Customer $model
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('reports.cdr.index', ['cdrs' => [], 'request' => []]);
    }

    public function search(CdrRequest $request)
    {
        $customer = Auth::user()->customer;
        $cdrs = (new GetCDR())->execute($customer, $request->all());

        return view('reports.cdr.index', ['cdrs' => $cdrs, 'request' => $request->all()]);
    }
}
