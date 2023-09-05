<?php

namespace App\Http\Controllers;

use App\Actions\Customer\UserAction;
use App\Models\Customer;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function create()
    {
        return view('users.add');
    }

    public function store(Customer $customer, Request $request)
    {
        $response = (new UserAction())->execute($customer, [
            'action' => 'ADD',
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response) {
            return redirect()->route('users.index', [$customer->accountcode]);
        }

        return view('users.add')->with('message', 'Houve um problema ao criar o usuario');
    }

    public function index(Customer $customer)
    {
        $users = (new UserAction())->execute($customer, [
            'action' => 'GET',
        ]);

        return view('users.index', ['users' => $users]);
    }

    public function me(Request $request)
    {
        if (\Auth::user()) {
            return response()->json([
                'response' => true,
                'user_id' => \Auth::user()->id,
                'name' => \Auth::user()->name,
                'accountcode' => \Auth::user()->customer->accountcode,
            ]);
        }

        return response()->json(['response' => false]);
    }

    public function edit(Customer $customer, $id)
    {
        $success = true;

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

    public function update(Customer $customer, Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

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

    public function destroy(Customer $customer, $id)
    {
        $b64 = json_decode(base64_decode($id));
        //$customer = Auth::user()->customer;
        (new UserAction())->execute($customer, [
            'action' => 'DELETE',
            'id' => $b64->id,
        ]);

        return response()->json(['success' => true]);
    }
}
