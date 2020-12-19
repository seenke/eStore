<?php


namespace App\Http\Controllers;
use App\Mail\ConfirmationMail;
use App\Models\Adress;
use App\Models\Order;
use App\Models\OrderStoreItem;
use App\Models\PostOffice;
use App\Models\Rating;
use App\Models\Role;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartStoreItem;
use App\Models\Status;
use App\Models\StoreItem;
use App\Models\User;
use App\Models\UserAccount;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
class UserController extends Controller
{

    // On frontend this is registration
    public function create (Request $request)
    {

        try {
            $accountData = $request->json('accountData');
            $addressData = $request->json('addressData');
            $postOfficeData = $request -> json('postOfficeData');

            //IMPORTANT ADD AUTHORIZATION FOR ADMIN --> ONLY ADMIN CAN PERFORM USER CREATING WITH SPECIFYING ROLES!
            if($accountData['role'] !== null) {
                $role = Role::where('role', $accountData['role'])->get();
            }else {
                $role = Role::where('role', 'customer')->get();
            }

            if (count($role) == 0) {
                $role = new Role();
                $roleName = $accountData['role'] != null ? $accountData['role'] : 'customer';
                $role->fill([
                    "role" => $roleName
                ]);
                $role->save();
            }else {
                $role = $role[0];
            }

            //Creating user
            $user = new User();
            $user->save();

            //Creating userAccount hasing password and generating API token
            $confirmationCode = substr(md5(mt_rand()), 0, 7);
            $userAccount = new UserAccount();
            $accountData['password'] = Hash::make($accountData['password']);
            $accountData['api_token'] = Str::random(60);
            $accountData['confirmation_code'] = $confirmationCode;


            $userAccount->fill($accountData);
            $userAccount->role()->associate($role);

            //Matching user with address, postOffice and account
            $postOffice = PostOffice::find($postOfficeData['id']);
            $userAccount->belongsTo($user);
            $user->userAccount()->save($userAccount);

            //Add shopping caart to customer, maybe replace with polymorphic relation in future
            if ($role['role'] == 'customer') {
                $shoppingCart = new ShoppingCart();
                $user->shoppingCart()->save($shoppingCart);
            }


            $address = new Adress();
            $address->fill($addressData);
            $address->postOffice()->associate($postOffice);
            $address->user()->associate($user);
            $user->address()->save($address);
            $user->save();


            $email = new ConfirmationMail($confirmationCode, "testiramo malo");
            Mail::to($accountData['email'])->send($email);
            return $userAccount;
        }catch (QueryException $e) {
            return $this->handleError($e);
        }

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

    public function createSelfOrder (Request $request)
    {
        $userAccount = $this->authUser();
        if ($userAccount == false) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if (!$this->authorizeUser('customer')) {
            return response()->json(['error' => 'Not allowed'],403);
        }
        $user = $userAccount->user()->get()[0];
        $status = Status::where('status', 'neobdelano')->get();
        if (count($status) == 0) {
            $status = new Status();
            $status->fill([
                "status" => "neobdelano"
            ]);
            $status->save();
        }

        $order = new Order();

        $order->user()->associate($user);
        $order->status()->associate($status[0]);
        $order->save();

        $orderItems = $request->json('orderItems');
        foreach ($orderItems as $orderItem)
        {
            $storeItemModel = StoreItem::find($orderItem['id']);
            $orderItemModel = new OrderStoreItem();
            $orderItemModel->fill([
                "quantity" => $orderItem['quantity'],
                "primary_price" => $orderItem['price']
            ]);
            $orderItemModel->storeItem()->associate($storeItemModel);
            $orderItemModel->order()->associate($order);
            $orderItemModel->save();
        }

        return $order->storeItems()->get();
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

    public function getSelf (Request  $request)
    {

        $userAccount = $this->authUser();
        if ($userAccount == false) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if (!$this->authorizeUser('customer')) {
            return response()->json(['error' => 'Not allowed'],403);
        }

        return $userAccount->only([
            'id',
            'name',
            'lastname',
            'email'
        ]);
    }

    public function selfUpdateShoppingCart (Request $request) {
        $userAccount = $this->authUser();
        if ($userAccount == false) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if (!$this->authorizeUser('customer')) {
            return response()->json(['error' => 'Not allowed'],403);
        }

        $user =$userAccount->user()->get()[0];
        $shoppingCart = $user -> shoppingCart()->get()[0];
        $updatedCart = $request->json('shoppingCart');

        $shoppingCart->items()->detach();
        foreach($updatedCart as $storeItem) {

            $storeItemModel = StoreItem::find($storeItem['id']);
            $itemModel = new ShoppingCartStoreItem();
            $itemModel->fill([
                "quantity"=>$storeItem['quantity']
            ]);

            $itemModel->shoppingCart()->associate($shoppingCart);
            $itemModel->storeItem()->associate($storeItemModel);
            $itemModel->save();
        }
        return $shoppingCart->items()->get();
    }

    public function selfGetShoppingCart (Request $requst) {
        $userAccount = $this->authUser();

        if ($userAccount == false) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        if (!$this->authorizeUser('customer')) {
            return response()->json(['error' => 'Not allowed'],403);
        }
        $user =$userAccount->user()->get()[0];
        $shoppingCart = $user -> shoppingCart()->get()[0];

        $items = $shoppingCart->items()->get();
        return $items;
    }


    //TODO: implement logic for self updating, order adding etc ...
    public function getSelfOrder (Request $request)
    {
        try {
            $userAccount = $this->authUser();
            if ($userAccount == false) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            if (!$this->authorizeUser('customer')) {
                return response()->json(['error' => 'Not allowed'],403);
            }
            $user = $userAccount->user()->get()[0];
            $responseArr = ["orders" => []];
            foreach ($user->orders()->get() as $order) {
                $orderArr = [
                    "storeItems" => $order -> storeItems() -> get(),
                    "order" => $order,
                    "status" => $order -> status() -> get()[0]
                ];
                array_push($responseArr["orders"], $orderArr);
            }

        }catch ( \Exception $exception ) {
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        return response() -> json($responseArr, 200);
    }

    public function selfUpdate (Request $request)
    {
        try{
            $userAccount = $this->authUser();
            if ($userAccount == false) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            if ($request->json('email') !== null) {
                response() -> json(['error' => 'email naslov ni posodobljiv', 400]);
            }
            if ($request->json('email') !== null) {
                response() -> json(['error' => 'vloga ni posodobljiva', 400]);
            }
            if ($request->json('password') != null) {
                $request['password'] = Hash::make($$request['password']);
            }
            $userAccount->update($request->all());
            $userAccount->save();
            $userAccount['role'] = $userAccount['role']['role'];
            return response()->json( $userAccount->only([
                'name',
                'lastname',
                'role',

            ]), 200);
        }catch (QueryException $exception) {
            return response()->json([
                'error'=>$exception->getMessage()
            ],500);
        }
    }

    public function selfAddRating(Request $request)
    {
        try{
            $userAccount = $this->authUser();
            if ($userAccount == false) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            $user = $userAccount->user()->get()[0];

            $ratings = $user->ratings()->get();
            if ($request['rating'] > 5 || $request['rating'] < 1) {
                return esponse()->json([
                    'error' => 'Ocena mora biti v razponu od 1-5'
                ],400);
            }
            foreach ($ratings as $rating) {
                if ($rating['store_item_id'] ==  $request['store_item_id']){
                    return response()->json([
                        'error' => 'Ta artikel ste ze ocenili'
                    ],400);
                }
            }
            $storeItem = StoreItem::find($request['store_item_id']);
            if (count($storeItem->get()) == 0) {
                return response()->json([
                    'error' => 'Artikel s podanim identifikatorjem ne obstaja'
                ], 400);
            }

            $rating = new Rating();
            $rating->fill($request->all());
            $rating->user()->associate($user);
            $rating->storeItem()->associate($storeItem);

            $rating->save();

            return response()->json([
                "message" => "Ocena uspesno oddana"
            ],200);

        }catch (QueryException $exception) {

            return response()->json([
                'error'=>$exception->getMessage()
            ],500);
        }
    }
}
