<?php

namespace App\Http\Controllers;

use App\Actions\Customer\CustomerAction;
use App\Actions\Customer\ShowDashboard;
use App\Http\Requests\CustomerPlanRequest;
use Auth;
use Illuminate\Http\Request;

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
            $dashboard = (new ShowDashboard())->execute($customer, []);

            return view('dashboard', ['dashboard' => $dashboard]);
        }
    }
}
