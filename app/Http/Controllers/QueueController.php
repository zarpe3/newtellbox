<?php

namespace App\Http\Controllers;

use App\Actions\Asterisk\Queue\AddQueue;
use App\Actions\Asterisk\Queue\EditQueue;
use App\Actions\Asterisk\Queue\GetQueue;
use App\Actions\Asterisk\SIP;
use App\Http\Requests\QueueRequest as QueueRequest;
use App\Models\Queue;
use Auth;

class QueueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = Auth::user()->customer;
        $queues = (new GetQueue())->execute($customer, []);
        $response = (new SIP())->execute($customer, ['request' => 'GET']);

        if (!$response['success']) {
            $response['success'] = false;
            $response['msg'] = 'Você não possui ramais cadastrados';
        }

        return view('queue.index', [
            'queues' => $queues,
            'success' => $response['success'],
            'extens' => $response['extens'],
            'message' => $response['msg'],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer = Auth::user()->customer;
        $response = (new SIP())->execute($customer, ['request' => 'GET']);

        if (!$response['success']) {
            $response['success'] = false;
            $response['msg'] = 'Você não possui ramais cadastrados';
        }

        return view('queue.add', [
            'success' => $response['success'],
            'extens' => $response['extens'],
            'message' => $response['msg'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(QueueRequest $request, AddQueue $queue)
    {
        $queue->execute(Auth::user()->customer, $request->all());

        return redirect('/queue');
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
        ///dump('ok');
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
        $queue = (new GetQueue())->execute($customer, ['id' => $id]);
        $response = (new SIP())->execute($customer, ['request' => 'GET']);

        $strategy = ['ringall' => 'Ringar Todos', 'roundrobin' => 'Aleatório', 'leastrecent' => 'Menos Recente'];

        //dd($queue[0]);

        return view('queue.edit', [
            'success' => true,
            'strategy' => $strategy,
            'agentReplacement' => 'Local/',
            'contextReplacement' => '@queue_out/n',
            'extens' => $response['extens'],
            'queue' => $queue[0],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(QueueRequest $request, EditQueue $queue, $id)
    {
        $params = $request->all();
        $params['id'] = $id;

        $queue->execute(Auth::user()->customer, $params);

        return redirect('/queue');
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
        //dump($id);
        Queue::find($id)->delete();
    }
}
