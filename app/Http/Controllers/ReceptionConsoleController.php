<?php

namespace App\Http\Controllers;

use App\Actions\Asterisk\SIP;
use App\Actions\Customer\ReceptionConsole;
use Illuminate\Http\Request;
use App\Models\Customer;

class ReceptionConsoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        $extens = (new SIP())->execute($customer, ['request' => 'GET']);

        return view('reception.index', ['extens' => $extens['extens']]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function hangup(Customer $customer, Request $request)
    {
        return (new ReceptionConsole())->execute($customer, [
            'request' => 'HANGUP',
            'channel' => $request->channel,
        ]);
    }

    public function transfer(Customer $customer, Request $request, $exten)
    {
        return (new ReceptionConsole())->execute($customer, [
            'request' => 'TRANSFER',
            'channel' => $request->channel,
            'exten' => $exten,
        ]);
    }

    public function spy(Customer $customer, Request $request, $exten)
    {
        return (new ReceptionConsole())->execute($customer, [
            'request' => 'SPY',
            'channel' => $request->channel,
            'exten' => $exten,
        ]);
    }
}
