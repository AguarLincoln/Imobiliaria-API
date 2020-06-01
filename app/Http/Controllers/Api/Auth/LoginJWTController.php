<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Messagens\ApiMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginJWTController extends Controller
{
    public function login(Request $request)
    {   
        $t = auth()->guard();
        dd($t);
        $credentials = $request->only(['email', 'password']);
        
        Validator::make($credentials,[
            'email' => 'required|string',
            'password' => 'required|string'
        ])->validate();

        if(!$token = auth('api')->attempt($credentials)){
            $message = new ApiMessages('Email ou senha inválido');
            return response()->json($message->getMessage(), 401);
        }

        return response()->json([
            'token' => $token
        ]);
    }

    public function logout(){
        auth('api')->logout();
        return response()->json(['deslogado com sucesso!'], 200);
    }

    public function refresh()
    {
        $token = auth('api')->refresh();

        return response()->json([
            'token' => $token
        ]);
    }
}
