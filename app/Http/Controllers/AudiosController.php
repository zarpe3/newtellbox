<?php

namespace App\Http\Controllers;

use App\Actions\Customer\Audios\DeleteAudio;
use App\Actions\Customer\Audios\ListAudios;
use App\Actions\Customer\Audios\SaveAudio;
use App\Models\Customer;
use Illuminate\Http\Request;

class AudiosController extends Controller
{
    /**
     * Display a listing of the audios.
     *
     * @return \Illuminate\View\View
     */
    public function index(Customer $customer)
    {
        $audios = (new ListAudios())->execute($customer, []);

        return view('audios.index', ['audios' => $audios]);
    }

    public function create()
    {
        return view('audios.add');
    }

    /**
     * Add a new audios.
     */
    public function store(Customer $customer, Request $request)
    {
        ((new SaveAudio())->execute($customer, [
            'name' => $request->name,
            'file' => $request->file('file'),
        ]));

        return view('audios.add', ['message' => 'O audio está sendo convertido, por favor aguarde alguns segundos']);
    }

    public function show()
    {
    }

    public function edit()
    {
    }

    public function destroy(Customer $customer, $fileName)
    {
        return (new DeleteAudio())->execute($customer, ['fileName' => $fileName]);
    }
}
