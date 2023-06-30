<?php

namespace App\Http\Controllers;

use App\Actions\Asterisk\SIP;
use App\Actions\Customer\Mailing\AddMailing;
use App\Actions\Customer\Mailing\DeleteMailing;
use App\Actions\Customer\Mailing\GetMailing;
use App\Actions\Customer\Mailing\StartMailing;
use App\Actions\Customer\Mailing\StopMailing;
use App\Actions\Customer\Mailing\UpdateMailing;
use App\Actions\Customer\Mailing\OnGoingMailing as OnGoing;
use Auth;
use Illuminate\Http\Request;

class MailingController extends Controller
{
    /**
     * index.
     *
     * @return void
     */
    public function index()
    {
        return view('mailing.index');
    }

    /**
     * create.
     *
     * @return void
     */
    public function create()
    {
        $customer = Auth::user()->customer;
        $response = (new SIP())->execute($customer, ['request' => 'GET', 'onlyName' => false]);

        if (!$response['success']) {
            $response['success'] = false;
            $response['msg'] = 'Você não possui ramais cadastrados';
        }

        return view('mailing.add', [
            'success' => $response['success'],
            'extens' => $response['extens'],
            'routes' => $response['routes'],
            'message' => $response['msg'],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $customer = Auth::user();
        $response = (new AddMailing())->execute($customer->customer, [
            'action' => 'import',
            'user_id' => $customer->id,
            'amd' => $request->amd,
            'agents' => explode(',', $request->agents),
            'bina' => $request->bina,
            'wrapuptime' => $request->wrapuptime,
            'timeout' => $request->timeout,
            'max_attempts' => $request->max_attempts,
            'strength' => $request->strength,
            'customer_id' => $customer->customer->id,
            'mailing' => $request->file('file'),
            'valid_cpf' => $request->valid_cpf ?? '1',
            'route' => $request->route,
            'calendar' => json_decode($request->calendar, true) ?? [],
            'campaign_name' => $request->campaign_name ?? 'padrão',
        ]);

        return $response;
    }

    /**
     * exportError.
     *
     * @param Request request
     *
     * @return void
     */
    public function exportError(Request $request)
    {
        return response()->download(base64_decode($request->file_path_error));
    }

    public function followUp(Request $request)
    {
        $customer = Auth::user();
        $response = (new GetMailing())->execute($customer->customer, []);

        return $response;
    }

    /**
     * show.
     *
     * @param mixed id
     *
     * @return void
     */
    public function show($id)
    {
        $customer = Auth::user()->customer;
        $extens = (new SIP())->execute($customer, ['request' => 'GET', 'onlyName' => false]);
        $mailing = (new GetMailing())->execute($customer, ['id' => $id]);

        return view('mailing.edit', [
            'extens' => $extens['extens'],
            'routes' => $extens['routes'],
            'mailing' => json_encode($mailing),
        ]);
    }

    public function update(Request $request, $id)
    {
        $customer = Auth::user()->customer;
        $data = array_merge(['id' => $id], $request->all());

        return (new UpdateMailing())->execute($customer, $data);
    }

    /**
     * destroy.
     *
     * @param mixed id
     *
     * @return void
     */
    public function destroy($id)
    {
        return (new DeleteMailing())->execute(Auth::user()->customer, ['id' => $id]);
    }

    /**
     * start.
     *
     * @param mixed id
     *
     * @return void
     */
    public function start($id)
    {
        $customer = Auth::user()->customer;

        return (new StartMailing())->execute($customer, [
            'id' => $id,
        ]);
    }

    /**
     * pause.
     *
     * @param mixed id
     *
     * @return void
     */
    public function pause($id)
    {
        $customer = Auth::user()->customer;

        return (new StopMailing())->execute($customer, [
            'id' => $id,
        ]);
    }

    /**
     * ongoing.
     *
     * @param Request request
     *
     * @return void
     */
    public function ongoing(Request $request)
    {
        \Log::info(print_r($request->all(), true));
        //OnGoingMailing::dispatch($request->campaign_id, $request->phones);
        (new OnGoing())->execute([
            'campaign_id' => $request->campaign_id,
            'phones' => $request->phones,
            'id' => $request->id,
        ]);
    }
}
