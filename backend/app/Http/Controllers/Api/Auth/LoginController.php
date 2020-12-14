<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserAccountController;
use App\Models\UserAccount;
use Illuminate\Http\Request;

class LoginController extends Controller
{


    public function login (Request $request)
    {
        $credentials = $request-> only(['email', 'password']);

        //check if user confirmed account
        $userAccount = UserAccount::where('email', $credentials['email'])->first();

        if($userAccount == null) {
            return response()->json(['error'=> "Napacno geslo ali email naslov"], 401);
        }

        if ($userAccount['confirmed'] == 0) {
            return response()->json(['error'=>"Prosimo potrdite svoj uporabniski racun"], 401);
        }

        if (!$token = auth() -> attempt($credentials)) {
            return response() -> json(['error' => 'Napacno geslo ali email naslov'], 401);
        }

        $userAccount['role'] = $userAccount -> role() -> first()['role'];

        return  response()->json(['token' => $token, 'user' => $userAccount->only(['name', 'lastname', 'email', 'role'])]);
    }

    public function confirmAccount (Request $request)
    {
        $credentials = $request->only(['email', 'confirmation_code']);

        $userAccount = UserAccount::where('email', $credentials['email'])->first();

        if ($userAccount['confirmed'] == 1) {
            return response()->json(['error'=> 'Uporabniski racun je ze potrjen'], 400);
        }

        if ($userAccount['confirmation_code'] == $credentials['confirmation_code']) {
            $userAccount['confirmed'] = 1;
            $userAccount->save();
            return response()->json(['message' => 'Uporabniski racun uspesno potrjen'], 200);
        }

        return response()->json(['error'=>'Napacna koda'], 400);
    }
}
