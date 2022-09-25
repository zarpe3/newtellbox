<?php

namespace App\Http\Controllers;

use App\Actions\Customer\GetCDR;
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
        $customer = Auth::user()->customer;
        $cdrs = (new GetCDR())->execute($customer, []);

        return view('reports.cdr.index', ['cdrs' => $cdrs]);
    }
}
