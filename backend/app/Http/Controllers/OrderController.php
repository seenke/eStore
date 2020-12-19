<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getAllOrders (Request $request)
    {
        $orders = Order::all();

        $responseArr = ["orders" => []];
        foreach ($orders as $order)
        {
            //TODO: authorize to only ADMIN and SELLER

            $user =  $order -> user() -> get()[0];
            $userAccount = $user->userAccount()->get();
            if (count($userAccount)== 0) {
                $userData = [
                    "id" => "UPORABNIK IZBRISAN",
                    "name" => "UPORABNIK IZBRISAN",
                    "lastname" =>"UPORABNIK IZBRISAN",
                    "email" => "UPORABNIK IZBRISAN"
                ];
            }else {
                $userData = $userAccount[0]->only([
                        'id',
                        'name',
                        'lastname',
                        'email'
                ]);
            }
            $orderArr = [
                "storeItems" => $order -> storeItems() -> get(),
                "order" => $order,
                "status" => $order -> status() -> get()[0],
                "user" => $userData
            ];
            array_push($responseArr["orders"], $orderArr);
        }

        return $responseArr;
    }

    public function updateOrder (Request $request)
    {
        //TODO: authorize to only ADMIN and SELLER
        $order = Order::find($request['orderId']);
        $allowedStatuses = ['neobdelano', 'preklicano', 'potrjeno', 'stornirano'];
        if(!in_array($request['statusName'], $allowedStatuses)){
          return response()->json([
              "error" => "Podan status ni veljaven"
          ], 400);
        }
        $status = Status::where('status', $request['statusName'])->get();

        if (count($status) == 0) {
            $status = new Status();
            $status->fill([
                "status" => $request['statusName']
            ]);
            $status->save();
        }else {
            $status = $status[0];
        }

        $order->status()->associate($status);
        $order->save();

        return $order;
    }
}
