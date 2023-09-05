<?php

namespace App\Http\Controllers;

use App\Actions\Asterisk\Inbound\AddInbound;
use App\Actions\Asterisk\Inbound\DeleteInbound;
use App\Actions\Asterisk\Inbound\EditInbound;
use App\Actions\Asterisk\Inbound\GetInbound;
use App\Actions\Asterisk\Queue\GetQueue;
use App\Actions\Asterisk\SIP;
use App\Actions\Customer\IVR\ListIVR;
use App\Http\Requests\InboundRequest;
use App\Models\Customer;

class InboundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        $inbounds = (new GetInbound())->execute($customer, []);

        return view('inbound.index', ['inbounds' => $inbounds]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Customer $customer)
    {
        $extens = (new SIP())->execute($customer, ['request' => 'GET']);
        $queues = (new GetQueue())->execute($customer, []);
        $ivrs = (new ListIVR())->execute($customer, []);

        return view('inbound.add', [
            'extens' => $extens['extens'],
            'queues' => $queues,
            'ivrs' => $ivrs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Customer $customer, InboundRequest $request)
    {
        try {
            (new AddInbound())->execute($customer, $request->all());

            return redirect()->route('inbound.index', [$customer->accountcode]);
        } catch (\Exception $e) {
            $inbounds = (new GetInbound())->execute($customer, []);

            return view('inbound.index', ['inbounds' => $inbounds])
                ->with('success', false)
                ->with('message', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer, $id)
    {
        $extens = (new SIP())->execute($customer, ['request' => 'GET']);
        $queues = (new GetQueue())->execute($customer, []);
        $ivrs = (new ListIVR())->execute($customer, []);
        $inbound = (new GetInbound())->execute($customer, ['id' => $id]);

        return view('inbound.edit', [
            'inbound' => $inbound,
            'id' => $id,
            'extens' => $extens['extens'],
            'queues' => $queues,
            'ivrs' => $ivrs,
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
    public function update(Customer $customer, InboundRequest $request, $id)
    {
        $params = array_merge($request->all(), ['id' => $id]);
        (new EditInbound())->execute($customer, $params);

        return redirect()->route('inbound.index', [$customer->accountcode])->with('success', true)->with('message', 'Rota atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer, $id)
    {
        return (new DeleteInbound())->execute($customer, ['b64' => $id]);
    }
}
