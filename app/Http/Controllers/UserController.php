<?php


namespace App\Http\Controllers;
use App\Models\Adress;
use App\Models\Order;
use App\Models\PostOffice;
use App\Models\Role;
use App\Models\Status;
use App\Models\StoreItem;
use App\Models\User;
use App\Models\UserAccount;
use Illuminate\Http\Request;

class UserController
{
    public function create (Request $request)
    {
        $accountData = $request->json('accountData');
        $addressData = $request->json('addressData');
        $postOfficeData = $request -> json('postOfficeData');

        $role = Role::where('role', 'customer')->get();

        if (count($role) == 0) {
            $role = new Role();
            $role->fill([
                "role" => "customer"
            ]);
            $role->save();
        }else {
            $role = $role[0];
        }

        //Creating user
        $user = new User();
        $user->save();

        //Creating userAccount
        $userAccount = new UserAccount();
        $userAccount->fill($accountData);
        $userAccount->role()->associate($role);

        //Matching user with address, postOffice and account
        $postOffice = PostOffice::find($postOfficeData['id']);
        $userAccount->belongsTo($user);
        $user->userAccount()->save($userAccount);


        $address = new Adress();
        $address->fill($addressData);
        $address->postOffice()->associate($postOffice);
        $address->user()->associate($user);
        $user->address()->save($address);
        $user->save();


        return $userAccount;

    }

    public function createOrder (Request $request)
    {
        $user = User::find($request->route('id'));

        $order = new Order();
        $order->user()->associate($user);

        $status = Status::where('status', 'new')->get();
        if (count($status) == 0) {
            $status = new Status();
            $status->fill([
                "status" => "new"
            ]);
            $status->save();
        }
        else {
            $status = $status[0];
        }

        $order->status()->associate($status);
        $order->save();


        $storeItems = $request->json('storeItems');
        $storeItemModels = [];
        foreach ($storeItems as $storeItem) {
            $storeItemModel = StoreItem::find($storeItem['id']);
            array_push($storeItemModels, $storeItemModel);
        }

        $order->storeItems()->saveMany($storeItemModels);

        return $storeItemModels;
    }

    public function getAllOrders (Request $request)
    {
        $user = User::find($request->route('id'));

        $orderResponse = [];
        foreach ($user->orders()->get() as $order)
        {
            array_push($orderResponse, $order, $order->storeItems()->get(), $order->status()->get());
        }

        return $orderResponse;
    }

    public function getAll (Request $request)
    {
       $allUsers = User::all();
       $response = [];
       foreach($allUsers as $user) {
           array_push($response,$user->userAccount()->get(), $user->address()->get());
       }
       return $response;
    }

    public function get (Request $request)
    {
        $user = User::find($request->route('id'));

        return $user->userAccount()->get();
    }

    public function update (Request $request)
    {
        //IMPLEMENT UPDATING
    }

    public function delete (Request $request)
    {
        //IMPLEMENT DELETING
    }
}
