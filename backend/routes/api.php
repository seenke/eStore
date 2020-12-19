<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\AdressController;
use \App\Http\Controllers\UserAccountController;
use \App\Http\Controllers\StoreItemController;
use \App\Http\Controllers\PostOfficeController;
use \App\Http\Controllers\RoleController;
use \App\Http\Controllers\UserController;
use \App\Models\StoreItem;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::apiResource([
//    'user' => UserAccountController::class
//]);

//Route::get('/testing-the-api', [AdressController::class, 'store']);

//Route::get('/test', [AdressController::class, 'getAll']);

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


//POST_OFFICE
Route::get("/postOffice", [PostOfficeController::class, 'getAll']);
Route::get("/postOffice/{id}", [PostOfficeController::class, 'get']);
Route::post("/postOffice", [PostOfficeController::class, 'create']);
Route::put("/postOffice", [PostOfficeController::class, 'update']);
Route::delete("/postOffice/{id}", [PostOfficeController::class, 'delete']);


//STORE_ITEM
Route::get("/storeItem", [StoreItemController::class, 'getAll']);
Route::get("/storeItem/{id}", [StoreItemController::class, 'get']);
Route::post("/storeItem", [StoreItemController::class, 'create']);
Route::put("/storeItem",[StoreItemController::class, 'update']);
Route::delete("/storeItem/{id}", [StoreItemController::class, 'delete']);
Route::delete("/storeItem", [StoreItemController::class, 'deleteAll']);

//USER_ROLE
Route::get("/role", [RoleController::class, 'getAll']);
Route::get("/role/{id}", [RoleController::class, 'get']);
Route::post("/role", [RoleController::class, 'create']);
Route::put("/role",[RoleController::class, 'update']);
Route::delete("/role/{id}", [RoleController::class, 'delete']);

//USER
Route::get("/user/self", [UserController::class, 'getSelf']);
Route::put("/user/self", [UserController::class, 'selfUpdate']);
Route::get("/user/self/order", [UserController::class, 'getSelfOrder']);
Route::post("/user/self/order", [UserController::class, 'createSelfOrder']);
Route::put("/user/self/shoppingCart", [UserController::class, 'selfUpdateShoppingCart']);
Route::get("/user/self/shoppingCart", [UserController::class, 'selfGetShoppingCart']);
Route::post("/user/self/rating", [UserController::class, 'selfAddRating']);
Route::get("/user", [UserController::class, 'getAll']);
Route::get("/user/{id}", [UserController::class, 'get']);
//Route::get("/user/{id}/order", [UserController::class, 'getAllOrders']);
Route::get("/user/{id}/order/{orderId}", [UserController::class, 'getOrder']);
Route::post("/user/{id}/order", [UserController::class, 'createOrder']);
Route::post("/user", [UserController::class, 'create']);

//ORDER
Route::get("/order", [\App\Http\Controllers\OrderController::class, 'getAllOrders']);
Route::put("/order", [\App\Http\Controllers\OrderController::class, 'updateOrder']);

//AUTHENTICATION
Route::post('/login', [\App\Http\Controllers\Api\Auth\LoginController::class, 'login']);
Route::post('/confirm', [\App\Http\Controllers\Api\Auth\LoginController::class, 'confirmAccount']);

//USER ACCOUNT
Route::get("/userAccount", [UserAccountController::class, 'getAll']);
Route::put("/userAccount", [UserAccountController::class, 'update']);
Route::delete("/userAccount/{id}", [UserAccountController::class, 'delete']);
Route::get("/userAccount/restore/{id}", [UserAccountController::class, 'restore']);
Route::post("/userAccount", [UserAccountController::class, 'create']);

//IMAGE
Route::post("/picture", [\App\Http\Controllers\PictureController::class, 'create']);
Route::get("/picture", [\App\Http\Controllers\PictureController::class, 'getAll']);





