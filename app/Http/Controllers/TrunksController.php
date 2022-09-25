<?php

namespace App\Http\Controllers;

use App\Actions\Asterisk\GetTrunks;
use App\Actions\Asterisk\UpdateTrunks;
use Illuminate\Http\Request;
use Auth;

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
    public function index()
    {
        $customer = Auth::user()->customer;
        $trunks = (new GetTrunks())->execute($customer, []);

        return view('trunks.index', ['trunks' => $trunks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer = Auth::user()->customer;

        return view('trunks.add', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = Auth::user()->customer;
        (new UpdateTrunks())->execute($customer, [
            'request' => 'GET',
            'trunk' => $request->all(),
        ]);

        return redirect('/trunks');
    }

    /**
     * Display the specified resource.
     *
     * @param string $base64
     *
     * @return \Illuminate\Http\Response
     */
    public function show($base64)
    {
        $request = base64_decode($base64);
        $customer = Auth::user()->customer;
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
    public function update(Request $request, $id)
    {
        $customer = Auth::user()->customer;
        (new UpdateTrunks())->execute($customer, [
            'request' => 'GET',
            'trunk' => $request->all(),
        ]);

        return redirect('/trunks');
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
        $json = json_decode(base64_decode($id));
        $customer = Auth::user()->customer;
        (new ActionRouting())->execute($customer, [
            'request' => 'DELETE',
            'name' => $json->name,
        ]);

        return response()->json(['success' => true]);
    }
}
