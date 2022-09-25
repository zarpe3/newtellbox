<?php

namespace App\Http\Controllers;

use App\Actions\Customer\CustomerAction;
use App\Http\Requests\CustomerPlanRequest;
use Illuminate\Http\Request;
use Auth;

class CustomersController extends Controller
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
        return view('routes.index');
    }

    /**
     * addPlan.
     *
     * @param CustomerPlanRequest request
     *
     * @return void
     */
    public function addPlan(CustomerPlanRequest $request)
    {
        $customer = Auth::user()->customer;
        $customerAction = new CustomerAction();
        $response = $customerAction->execute(
            $customer,
            ['action' => 'addPlan', 'plan' => $request->plan]
        );

        if ($response) {
            return view('dashboard');
        }
    }
}
