<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Models\StoreItem;
use Illuminate\Http\Request;

class StoreItemController extends Controller
{
    public function create (Request $request)
    {
        $storeItemData = $request->json('storeItemData');
        $pictureData = $request->json('pictureData');

        $picturesModel = [];
        foreach ($pictureData as $picture) {
            $pictureModel = Picture::where('id', $picture['id'])->get()[0];
            array_push($picturesModel, $pictureModel);
        };

        $storeItem = new StoreItem();
        $storeItem->fill($storeItemData);
        $storeItem->save();
        $storeItem->pictures()->saveMany($picturesModel);

        return $storeItem;
    }

    public function getAll (Request $request)
    {

        $storeItems = StoreItem::all();
        $response = [];
        foreach ($storeItems as $storeItem) {
            $storeItemPictures = $storeItem -> pictures() -> get();
            $ratings = $storeItem -> ratings() -> get();
            array_push($response, [
                "storeItem"=>$storeItem,
                "pictures" => $storeItemPictures,
                "ratings" => $ratings
            ]);
        }

        return $response;
    }

    public function get (Request$request)
    {
        $this->authUser();
        $storeItem = StoreItem::find($request->route('id'));

        return [
            "storeItem" =>$storeItem,
            "pictures" => $storeItem->pictures()->get(),
            "ratings" => $storeItem->ratings() -> get()
        ];
    }

    public function update (Request $request)
    {

        $storeItemData = $request->json('storeItemData');
        $pictureData = $request->json('pictureData');

        $storeItem = StoreItem::where('id', $storeItemData['id'])->get()[0];

        $picturesModel = [];
        foreach ($pictureData as $picture) {
            $pictureModel = Picture::where('id', $picture['id'])->get()[0];
            array_push($picturesModel, $pictureModel);
        };

        $storeItem->update([
            "name" => $storeItemData['name'],
            "price" => $storeItemData['price'],
            "description" => $storeItemData['description']
        ]);

        $pictureIds = array_map(function ($value){
            return $value['id'];
        }, $picturesModel);

        $pictures = $storeItem->pictures()->get();
        foreach ($pictures as $picture) {
            if (!in_array($picture['id'], $pictureIds )) {
                $picture->delete();
            }
        }

        $storeItem->pictures()->saveMany($picturesModel);
        $storeItem->save();

        return $storeItem;

    }

    public function delete (Request $request)
    {
        $storeItem = StoreItem::where('id', $request->route('id'));

        $storeItem->delete();

        return $storeItem->get();
    }

    public function deleteAll (Request $request)
    {
        StoreItem::whereNotNull('id')->delete();
        return [
            "message"=>"all deleted"
        ];
    }
}
