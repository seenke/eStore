<?php

namespace App\Http\Controllers;

use App\Models\Adress;
use Illuminate\Http\Request;

class AdressController extends Controller
{
    //
    public function store (Request $request)
    {
        $address = new Adress;
        $address -> fill([
            "street" => "Kidricevo naselje ",
            "streetNumber" => "12a"
        ]);
        $address->save();
        return $address;
    }

    public function getAll (Request $request)
    {
        return Adress::all();
    }
}
