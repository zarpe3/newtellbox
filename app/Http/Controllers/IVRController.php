<?php

namespace App\Http\Controllers;

use App\Actions\Asterisk\Queue\GetQueue;
use App\Actions\Asterisk\SIP;
use App\Actions\Customer\Audios\ListAudios;
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
        $ivrs = [];

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
        $extens = (new SIP())->execute($customer, ['request' => 'GET', 'onlyExtens' => true]);

        return view('ivr.add', ['audios' => $audios, 'queues' => $queues, 'extens' => $extens]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
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
}
