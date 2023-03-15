<?php

namespace App\Http\Controllers;

use App\Actions\Asterisk\Queue\GetQueue;
use App\Actions\Asterisk\SIP;
use App\Actions\Customer\Audios\ListAudios;
use App\Actions\Customer\IVR\AddIVR;
use App\Actions\Customer\IVR\DeleteIVR;
use App\Actions\Customer\IVR\ListIVR;
use App\Actions\Customer\IVR\UpdateIVR;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IVRController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = Auth::user()->customer;
        $ivrs = (new ListIVR())->execute($customer, []);

        return view('ivr.index', ['ivrs' => $ivrs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer = Auth::user()->customer;
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
    public function store(Request $request)
    {
        $customer = Auth::user()->customer;
        (new AddIVR())->execute($customer, $request->all());

        return redirect()->route('ivr.index');
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
    public function edit($id)
    {
        $customer = Auth::user()->customer;
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
    public function update(Request $request, $id)
    {
        $customer = Auth::user()->customer;
        $request['id'] = $id;
        (new UpdateIVR())->execute($customer, $request->all());

        return redirect()->route('ivr.index');
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
        $customer = Auth::user()->customer;

        return (new DeleteIVR())->execute($customer, ['id' => $id]);
    }
}
