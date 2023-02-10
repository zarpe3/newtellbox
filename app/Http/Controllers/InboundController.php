<?php

namespace App\Http\Controllers;

use App\Actions\Asterisk\Inbound\AddInbound;
use App\Actions\Asterisk\Inbound\EditInbound;
use App\Actions\Asterisk\Inbound\GetInbound;
use App\Actions\Asterisk\Queue\GetQueue;
use App\Actions\Asterisk\SIP;
use App\Http\Requests\InboundRequest;
use Auth;

class InboundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = Auth::user()->customer;
        $inbounds = (new GetInbound())->execute($customer, []);

        return view('inbound.index', ['inbounds' => $inbounds]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer = Auth::user()->customer;
        $extens = (new SIP())->execute($customer, ['request' => 'GET']);
        $queues = (new GetQueue())->execute($customer, []);

        return view('inbound.add', [
            'extens' => $extens['extens'],
            'queues' => $queues,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(InboundRequest $request)
    {
        $customer = Auth::user()->customer;
        (new AddInbound())->execute($customer, $request->all());

        return redirect('/inbound');
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
        \Log::info('entrei no show');
        $customer = Auth::user()->customer;
        $extens = (new SIP())->execute($customer, ['request' => 'GET']);
        $queues = (new GetQueue())->execute($customer, []);
        $inbound = (new GetInbound())->execute($customer, ['id' => $id]);

        return view('inbound.edit', [
            'inbound' => $inbound,
            'id' => $id,
            'extens' => $extens['extens'],
            'queues' => $queues,
        ]);
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
        dd($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(InboundRequest $request, $id)
    {
        $customer = Auth::user()->customer;
        $params = array_merge($request->all(), ['id' => $id]);
        (new EditInbound())->execute($customer, $params);

        return redirect('/inbound')->with('success', true)->with('message', 'Rota atualizada com sucesso');
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
}
