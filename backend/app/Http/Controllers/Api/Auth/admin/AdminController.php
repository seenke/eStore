<?php


namespace App\Http\Controllers\Api\Auth\admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function certLogin (Request $request)
    {
        # preberemo odjemaÄev certifikat
        $client_cert = filter_input(INPUT_SERVER, "SSL_CLIENT_CERT");

        # in ga razÄlenemo
        $cert_data = openssl_x509_parse($client_cert);

        # preberemo ime uporabnika (polje "common name")
        $commonname = $cert_data['subject']['CN'];

        return response()-> json($commonname);
    }
}
