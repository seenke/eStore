<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login (Request $request)
    {
        $credentials = $request-> only(['email', 'password']);


        if (!$token = auth() -> attempt($credentials)) {
            return response() -> json(['error' => 'Incorrect password or email'], 401);
        }


        return  response()->json(['token' => $token]);
    }
}
