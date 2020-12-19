<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use Illuminate\Http\Request;

class PictureController extends Controller
{

    public function create (Request $request) {
//        if(!$request->hasFile('image')) {
//            return response()->json(['upload_file_not_found'], 400);
//        }
        $file = $request->file('image');
//        if(!$file->isValid()) {
//            return response()->json(['invalid_file_upload'], 400);
//        }∂
        $path = public_path() . '/storage/storeItems';
        $image = new Picture();
        $image->fill([
            "image" => $file->getClientOriginalName(),
        ]);
        $image->save();
        $image['image'] = strval($image['id'])."ID-".$image['image'];
        $image->save();
        $file->move($path, $image['image']);

        return response()->json($image);
    }

    public function getAll (Request $request) {
        return Picture::all();
    }
}
