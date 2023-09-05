<?php

namespace App\Http\Controllers;

use App\Actions\Asterisk\Queue\GetQueue;
use App\Actions\Asterisk\SIP;
use App\Actions\Customer\Audios\ListAudios;
use App\Actions\Customer\IVR\AddIVR;
use App\Actions\Customer\IVR\DeleteIVR;
use App\Actions\Customer\IVR\ListIVR;
use App\Actions\Customer\IVR\UpdateIVR;
use App\Models\Customer;
use Illuminate\Http\Request;

class IVRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Customer $customer)
    {
        $ivrs = (new ListIVR())->execute($customer, []);

        return view('ivr.index', ['ivrs' => $ivrs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Customer $customer)
    {
        $audios = (new ListAudios())->execute($customer, []);
        $queues = (new GetQueue())->execute($customer, []);
        $extens = (new SIP())->execute($customer, ['request' => 'GET', 'onlyExtens' => true, 'onlyName' => true]);

        $response['success'] = true;
        $response['msg'] = null;
        if (count($audios) == 0) {
            $response['msg'] = 'Você não possui nenhum audio cadastrado';
        }

        return view('ivr.add', [
            'audios' => $audios,
            'queues' => $queues,
            'extens' => $extens,
            'success' => $response['success'],
            'message' => $response['msg'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Customer $customer, Request $request)
    {
        (new AddIVR())->execute($customer, $request->all());

        return redirect()->route('ivr.index', [$customer->accountcode]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer, $id)
    {
        $ivr = (new ListIVR())->execute($customer, ['id' => $id]);
        $audios = (new ListAudios())->execute($customer, []);
        $queues = (new GetQueue())->execute($customer, []);
        $extens = (new SIP())->execute($customer, ['request' => 'GET', 'onlyExtens' => true]);

        return view('ivr.edit', [
            'ivr' => $ivr,
            'audios' => $audios,
            'queues' => $queues,
            'extens' => $extens,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Customer $customer, Request $request, $id)
    {
        $request['id'] = $id;
        (new UpdateIVR())->execute($customer, $request->all());

        return redirect()->route('ivr.index', [$customer->accountcode]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer, $id)
    {
        return (new DeleteIVR())->execute($customer, ['id' => $id]);
    }
}
