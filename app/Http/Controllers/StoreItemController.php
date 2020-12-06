<?php

namespace App\Http\Controllers;

use App\Models\StoreItem;
use Illuminate\Http\Request;

class StoreItemController extends Controller
{
    public function create (Request $request)
    {
        $storeItem = new StoreItem();
        $storeItem->fill($request->all());
        $storeItem->save();

        return $storeItem;
    }

    public function getAll (Request $request)
    {
        return StoreItem::all();
    }

    public function get (Request$request)
    {
        $storeItem = StoreItem::where('id', $request->route('id'))->get();

        return $storeItem;
    }

    public function update (Request $request)
    {
        $storeItem = StoreItem::where('id', $request->json('id'))
            -> update($request->all());

        return $request->all();

    }

    public function delete (Request $request)
    {
        $storeItem = StoreItem::where('id', $request->route('id'));

        $storeItem->delete();

        return $storeItem->get();
    }
}
