<?php

namespace App\Http\Controllers;

use App\Models\PostOffice;
use App\Models\UserAccount;
use Illuminate\Http\Request;

class UserAccountController extends Controller
{
    //
    function getAll(Request $request) {
        //TODO: ADD LOGIC FOR AUTHORIZATION AND AUTHENTICATION OF USER --> ONLY ADMIN AND SELLER ROLE ALLOWED
        $userAccounts =UserAccount::withTrashed()->get();

        $responseArr = [
            "activated" => [],
            "deactivated" => []
        ];

        foreach ($userAccounts as $userAccount) {
            $role = $userAccount->role()->get()[0];
            $address = $userAccount->user()->first()
                ->address()->first();
            $postOffice = $address->postOffice()->first();

            if ($role['role'] === 'customer') {
                $currentUserAccount = [
                    "id" => $userAccount['id'],
                    "name" => $userAccount['name'],
                    "lastname" => $userAccount['lastname'],
                    "email" => $userAccount['email'],
                    "role" => $role['role'],
                    "deleted_at" => $userAccount['deleted_at'],
                    "address" => [
                        "street" => $address['street'],
                        "street_number" => $address['street_number']
                    ],
                    "postOffice" => [
                        "postal_code" => $postOffice['postal_code'],
                        "post_office" => $postOffice['post_office']
                    ]
                ];
                if ($userAccount['deleted_at'] == null) {
                    array_push($responseArr['activated'], $currentUserAccount);
                }
                else {
                    array_push($responseArr['deactivated'], $currentUserAccount);
                }

            }
        }
        return $responseArr;
    }

    function update (Request $request) {
        $userAccount = UserAccount::withTrashed()->where('id', $request['id'])->get()[0];
        $user = $userAccount->user()->get()[0];
        $address = $user->address()->get()[0];
        $address->update([
            "street" => $request['address']['street'],
            "street_number" =>  $request['address']['street_number']
        ]);
        $address->save();

        $postOffice = PostOffice::where('post_office', $request['postOffice']['post_office'])->get();

        if(count($postOffice) == 0) {
            $postOffice = new PostOffice();
            $postOffice->fill([
                "post_office" => $request['postOffice']['post_office'],
                "postal_code" => $request['postOffice']['postal_code']
            ]);
            $postOffice->save();
        }

        $address->postOffice()->associate($postOffice);
        $address->save();
        $userAccount->fill([
            "name" => $request['name'],
            "lastname" => $request['lastname']
        ]);
        $userAccount->save();


        return response() -> json($request->all(), 200);
    }

    function delete (Request $request)
    {
        UserAccount::find($request->route('id'))->delete();

        return response() -> json([], 200);
    }

    function restore (Request $request)
    {
        UserAccount::withTrashed()->find($request->route('id'))->restore();
        return response() -> json([], 200);
    }
}
