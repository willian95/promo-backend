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

Route::get("/forgot-password", "ForgotPasswordController@index");
Route::post("/forgot-password", "ForgotPasswordController@verifyEmail");
Route::get("/forgot-password/validate/{forgotHash}", "ForgotPasswordController@changePasswordView");
Route::post("/forgot-password/change", "ForgotPasswordController@changePassword");

Route::get("/my-transfers", "PaymentController@myTransferViews");

Route::get("/post", "PostController@index");
Route::get("/post/show/{id}", "PostController@show");

Route::get("/my-purchases", "PurchaseController@index");
Route::get("/my-purchases/purchase/{id}", "PurchaseController@showMyPurchaseInfo");

Route::get("/my-sales", "SaleController@index");

Route::get("/my-profile", "ProfileController@index");
Route::get("/profile/{id}", "ProfileController@show");

Route::get("/explorer", "ExplorerController@index");

Route::get("/search", function(){
    return view("user/search");
});

/*Route::get("/mail-test", function(){

    $messageUser = "Hola prueba! Haz click en el siguiente enlace para validar tu correo";
    $to_email = "rodriguezwillian95@gmail.com";
    $to_name = "willian";
    $registerHash = "sdkjfdklfsdlf";
    
    $data = ["messageMail" => $messageUser, "registerHash" => $registerHash];
    \Mail::send("emails.confirmRegisterMail", $data, function($message) use ($to_name, $to_email) {

        $message->to($to_email, $to_name)->subject("¡Valida tu correo!");
        $message->from( env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));

    });

});*/

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

Route::get("/admin/ads/index", "AdsController@index");
Route::get("/admin/carousel/index", "CarouselController@index");

//Route::post("/register", "ContactUserController@store");


