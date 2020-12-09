<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function authUser ()
    {
        try {
            $userAccount = auth()->userOrFail();
        }catch (UserNotDefinedException $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

        return $userAccount;
    }

    public function authorizeUser ($role) {
        try {
            $userAccount = auth() -> userOrFail();
        }catch (UserNotDefinedException $e) {
            return false;
        }
        return $userAccount->role()->get()[0]['role'] == $role;
    }
}
