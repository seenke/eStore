<?php

namespace App\Http\Controllers\Api\Auth;
use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserAccountController;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        $userAccount = UserAccount::where('email', $credentials['email'])->get()[0];

        if ($userAccount['confirmed'] == 1) {
            return response()->json(['error'=> 'Uporabniski racun je ze potrjen'], 400);
        }

        if ( strval($userAccount['confirmation_code']) == $credentials['confirmation_code']) {
            $userAccount['confirmed'] = 1;
            $userAccount->save();
            return response()->json(['message' => 'Uporabniski racun uspesno potrjen'], 200);
        }

        return response()->json(['error'=>'Napacna koda'], 400);
    }

    public function certLogin (Request $request)
    {
        # preberemo odjemaÄev certifikat
        $client_cert = filter_input(INPUT_SERVER, "SSL_CLIENT_CERT");

        # in ga razÄlenemo
        $cert_data = openssl_x509_parse($client_cert);

        # preberemo ime uporabnika (polje "common name")
        $commonname = $cert_data['subject']['CN'];
        $email = $cert_data['subject']['emailAddress'];
        $geslo = "certifikati";
        $userAccount = UserAccount::where('email', $email)->get();
        if (count($userAccount) == 0) {
            return response()->json(['error'=> "Napacen certifikat"], 401);
        }

        $credentials = [
            'email' => $email,
            'password' => $geslo
        ];

        if (!$token = auth() -> attempt($credentials)) {
            return response() -> json(['error' => 'Napacno geslo ali email naslov'], 401);
        }

        $userAccount = $userAccount[0];
        $userAccount['role'] = $userAccount -> role() -> get() [0] ['role'];

        return  response()->json(['token' => $token, 'user' => $userAccount->only(['name', 'lastname', 'email', 'role'])]);
    }

        public function createAdminDummy (Request $request)
    {
        $userAccount = new UserAccount();
        $userAccount->fill([
            "name"=>"Sef",
            "lastname"=>"Sefe",
            "email" => "admin@gmail.com",
            "password" => Hash::make('certifikati'),
            "confirmation_code" => '12345'
        ]);

        $role = Role::where('role', 'admin')->get();
        if (count($role) == 0)
        {
            $role = new Role();
            $role->fill([
                "role" => "admin"
            ]);
            $role->save();
        }else {
            $role = $role[0];
        }

        $userAccount->role()->associate($role);

        $userAccount->save();

        return response()->json([
            "message"=>"uspesno ustvarjen nov uporabniski racun "
        ]);

        return $userAccount;
    }
}
