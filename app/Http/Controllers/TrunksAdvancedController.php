<?php

namespace App\Http\Controllers;

class TrunksController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @param \App\Models\User $model
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('trunks-advanced.index');
    }
}
