<?php

namespace App\Http\Controllers;

use App\Actions\Asterisk\DeleteTrunks;
use App\Actions\Asterisk\GetTrunks;
use App\Actions\Asterisk\UpdateTrunks;
use App\Http\Requests\TrunksRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class TrunksController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @param \App\Models\User $model
     *
     * @return \Illuminate\View\View
     */
    /**
     * Display a listing of the users.
     *
     * @param \App\Models\User $model
     *
     * @return \Illuminate\View\View
     */
    public function index(Customer $customer)
    {
        $trunks = (new GetTrunks())->execute($customer, []);

        return view('trunks.index', ['trunks' => $trunks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Customer $customer)
    {
        return view('trunks.add', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Customer $customer, TrunksRequest $request)
    {
        //$validated = $request->validated();
        (new UpdateTrunks())->execute($customer, [
            'request' => 'GET',
            'trunk' => $request->all(),
        ]);

        return redirect()->route('trunks.index', [$customer->accountcode]);
    }

    /**
     * Display the specified resource.
     *
     * @param string $base64
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer, $base64)
    {
        $request = base64_decode($base64);
        $trunks = (new GetTrunks())->execute($customer, []);

        return view('trunks.edit', ['id' => $base64, 'trunk' => $trunks['response'][$request]]);
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
    public function update(Customer $customer, Request $request, $id)
    {
        $response = (new UpdateTrunks())->execute($customer, [
            'request' => 'GET',
            'trunk' => $request->all(),
        ]);

        return redirect()->route('trunks.index', [$customer->accountcode]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer, $b64)
    {
        //dd($b64);
        $name = base64_decode($b64);
        $response = (new DeleteTrunks())->execute($customer, [
            'trunkName' => $name,
        ]);
        //return response()->json(['success' => true]);
    }
}
