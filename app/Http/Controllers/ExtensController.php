<?php

namespace App\Http\Controllers;

use App\Actions\Asterisk\SIP;
use Illuminate\Http\Request;
use Auth;

class ExtensController extends Controller
{
    /**
     * Display a listing of the extens.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $customer = Auth::user()->customer;
        $response = (new SIP())->execute($customer, ['request' => 'GET']);

        return view('extens.index', [
            'extens' => json_encode($response['extens']),
            'success' => $response['success'],
            'routes' => json_encode($response['routes']),
            'message' => $response['msg'],
        ]);
    }

    /**
     * Add a new extens.
     */
    public function store(Request $request)
    {
        $customer = Auth::user()->customer;

        return (new SIP())->execute($customer, ['request' => 'ADD', 'data' => $request->all()]);
    }

    public function destroy($name)
    {
        $customer = Auth::user()->customer;

        return (new SIP())->execute($customer, ['request' => 'DEL', 'name' => $name]);
    }
}
