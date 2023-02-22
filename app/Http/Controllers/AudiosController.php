<?php

namespace App\Http\Controllers;

use App\Actions\Customer\Audios\SaveAudio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AudiosController extends Controller
{
    /**
     * Display a listing of the audios.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $audios = [];

        return view('audios.index', ['audios' => $audios]);
    }

    public function create()
    {
        return view('audios.add');
    }

    /**
     * Add a new audios.
     */
    public function store(Request $request)
    {
        $customer = Auth::user()->customer;
        ((new SaveAudio())->execute($customer, [
            'name' => $request->name,
            'file' => $request->file('file'),
        ]));

        return view('audios.index', ['audios' => []]);
    }

    public function show()
    {
    }

    public function edit()
    {
    }

    public function destroy($name)
    {
    }
}
