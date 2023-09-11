<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ApiAuthController extends Controller
{
    function tokenCreate(Request $request)
    {
        $token = $request->user()->createToken($request->token_name);
        return ['token' => $token->plainTextToken];
    }

    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;

            return ['success' => true,'token' => $success['token'], 'msg' => 'User login successfully.'];
        }
        else{
            return ['success' => false, 'error'=>'Unauthorised'];
        }
    }
}
