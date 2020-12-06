<?php

namespace App\Http\Controllers;

use App\Models\PostOffice;
use Illuminate\Http\Request;

class PostOfficeController extends Controller
{
    public function create (Request $request)
    {
        $postOffice = new PostOffice();
        $postOffice->fill($request->all());
        $postOffice->save();

        return $postOffice;
    }

    public function getAll(Request $request)
    {
        return PostOffice::all();
    }

    public function get (Request $request)
    {
        $postOffice = PostOffice::where('id', $request->route('id'));

        return $postOffice -> get();
    }

    public function update (Request $request)
    {
        $postOffice = PostOffice::where('id', $request->json('id'));

        $postOffice->update($request->all());

        return $postOffice -> get();
    }

    public function delete (Request $request)
    {
        $postOffice = PostOffice::where('id', $request->route('id'));

        $postOffice->delete();

        return $postOffice->get();
    }


}
