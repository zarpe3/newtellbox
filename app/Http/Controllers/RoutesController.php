<?php

namespace App\Http\Controllers;

use App\Actions\Asterisk\SIPRoutes as ActionRouting;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RoutesController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @param \App\Models\User $model
     *
     * @return \Illuminate\View\View
     */
    public function index(Customer $customer)
    {
        $routes = (new ActionRouting())->execute($customer, ['request' => 'GET']);

        $response = Http::post('https://webdec-dev03.webdec.com.br/trunks/list', [
            'accountcode' => $customer->accountcode,
        ])->json();

        if (count($response['response']) == 0) {
            return view('routes.index', [
                'routes' => $routes,
                'success' => false,
                'message' => 'Você precisa primeiro cadastrar um tronco',
            ]);
        }

        return view('routes.index', ['routes' => $routes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Customer $customer)
    {
        $response = Http::post('https://webdec-dev03.webdec.com.br/trunks/list', [
          'accountcode' => $customer->accountcode,
        ]);
        $trunks = $response->json();
        //var_dump($trunks);
        return view('routes.add', ['trunks' => $trunks]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Customer $customer, Request $request)
    {
        (new ActionRouting())->execute($customer, [
            'request' => 'ADD',
            'infos' => $request->infos,
            'name' => $request->name,
        ]);

        return redirect()->route('routes.index', [$customer->accountcode]);
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
        $request = json_decode(base64_decode($base64));
        $response = Http::post('https://webdec-dev03.webdec.com.br/trunks/list', [
          'accountcode' => $request->accountCode,
        ]);
        $trunks = $response->json();
        $routes = (new ActionRouting())->execute($customer, ['request' => 'GET_ROUTE_NAME', 'name' => $request->name]);

        return view('routes.edit', ['id' => $base64, 'trunks' => $trunks, 'routes' => $routes]);
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
        (new ActionRouting())->execute($customer, [
            'request' => 'UPDATE',
            'infos' => $request->infos,
            'name' => $request->name,
        ]);

        return redirect()->route('routes.index', [$customer->accountcode]);
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
        $json = json_decode(base64_decode($id));
        (new ActionRouting())->execute($customer, [
            'request' => 'DELETE',
            'name' => $json->name,
        ]);

        return response()->json(['success' => true]);
    }
}
