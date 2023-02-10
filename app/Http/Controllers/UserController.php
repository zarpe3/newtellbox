<?php

namespace App\Http\Controllers;

use App\Actions\Customer\UserAction;
use Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        return view('users.add');
    }

    public function store(Request $request)
    {
        $customer = Auth::user()->customer;
        $response = (new UserAction())->execute($customer, [
            'action' => 'ADD',
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response) {
            return redirect('/users');
        }
    }

    public function index()
    {
        $customer = Auth::user()->customer;
        $users = (new UserAction())->execute($customer, [
            'action' => 'GET',
        ]);

        return view('users.index', ['users' => $users]);
    }

    public function me(Request $request)
    {
        if (Auth::user()) {
            return response()->json([
                'response' => true,
                'user_id' => Auth::user()->id,
                'name' => Auth::user()->name,
                'accountcode' => Auth::user()->customer->accountcode,
            ]);
        }

        return response()->json(['response' => false]);
    }

    public function edit($id)
    {
        $success = true;

        $customer = Auth::user()->customer;
        $user = (new UserAction())->execute($customer, [
            'action' => 'GET_ID',
            'id' => $id,
        ]);

        if ($user == null) {
            $success = false;

            return view('users.edit', ['success' => $success, 'message' => 'Usuario não encontrado']);
        }

        return view('users.edit', ['success' => $success, 'responseUser' => $user]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        $success = true;

        $customer = Auth::user()->customer;
        $response = (new UserAction())->execute($customer, [
            'action' => 'UPDATE',
            'id' => $id,
            'name' => $request->name,
            'password' => $request->password,
        ]);

        $users = (new UserAction())->execute($customer, [
            'action' => 'GET',
        ]);

        return view('users.index', [
            'users' => $users,
            'success' => $response['success'],
            'message' => $response['message'],
        ]);
    }

    public function destroy($id)
    {
        $b64 = json_decode(base64_decode($id));
        $customer = Auth::user()->customer;
        (new UserAction())->execute($customer, [
            'action' => 'DELETE',
            'id' => $b64->id,
        ]);

        return response()->json(['success' => true]);
    }
}
