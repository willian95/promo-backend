<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('register');
    return view('user.landing');
});

Route::get("login", "AuthController@loginView");
Route::get("register", "AuthController@registerView");
Route::get('/register/validate/{registerHash}', "AuthController@validateMail");

Route::get("/my-transfers", "PaymentController@myTransferViews");

Route::get("/post", "PostController@index");
Route::get("/post/show/{id}", "PostController@show");

Route::get("/my-purchases", "PurchaseController@index");
Route::get("/my-purchases/purchase/{id}", "PurchaseController@showMyPurchaseInfo");

Route::get("/my-sales", "SaleController@index");

Route::get("/my-profile", "ProfileController@index");
Route::get("/profile/{id}", "ProfileController@show");

Route::get("/explorer", "ExplorerController@index");

Route::get("/admin/dashboard", function(){

    return view("admin.index");

});

Route::get('/checkout', 'CheckoutController@initTransaction')->name('checkout'); 
Route::post('/checkout/webpay/response', 'CheckoutController@response')->name('checkout.webpay.response');  
Route::post('/checkout/webpay/finish', 'CheckoutController@finish')->name('checkout.webpay.finish');

Route::get("/admin/category/index", "CategoryController@categoryView");
Route::get("/admin/bank/index", "BankController@bankView");
Route::get("/admin/transfers/index", "PaymentController@transferViews");
Route::get("/admin/posts/index", "PostController@adminIndex");
Route::get("/admin/users/index", "UserController@index");

//Route::post("/register", "ContactUserController@store");


