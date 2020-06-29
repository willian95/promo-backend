<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/fetch', 'HomeController@fetch');
Route::get('/guest/fetch', 'HomeController@guestFetch');
Route::get('categories/fetch', 'HomeController@fetchCategories');

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');

Route::post('/post/checkSaleDate', 'PostController@checkSaleDate');
Route::post('/post/store', 'PostController@store');
Route::post('/post/check/active/reservations', "PostController@checkActiveReservations");

Route::get("/my-purchases/fetch/{page}", "PurchaseController@userFetch");
Route::post('/purchase/reserve', "PurchaseController@reserve");
Route::post('/purchase/confirmDelivery', "PurchaseController@confirmDelivery");

Route::get("/my-sales/fetch/{page}", "SaleController@userFetch");
Route::post("/my-sales/deliver", "SaleController@deliver");

Route::post("rate/store", "RateController@store");

Route::get("my-profile/data", "ProfileController@myData");
Route::post("my-profile/update", "ProfileController@update");
/*Route::get('/purchase/userFetch/{page}', "PurchaseController@userFetch");
Route::get("/my-transfers", "PaymentController@fetchMyPayments");*/

Route::get('/reservations/uncomplete', "PurchaseController@fetchUncompleteReservations");

Route::get('/orders/fetch', "OrderController@fetchReservations");

Route::get('/bank/fetch', "BankController@fetch");

Route::get('/checkUser', 'AuthController@getAuthenticatedUser');

Route::get("/regions", "LocationController@regionFetch");
Route::get("/commune/{region_id}", "LocationController@communeFetch");

Route::prefix('admin')->group(function (){

    Route::post("/category/store", "CategoryController@store")->name('admin.category.store');
    Route::post("/category/update", "CategoryController@update")->name('admin.category.update');
    Route::post("/category/delete", "CategoryController@delete")->name('admin.category.delete');
    Route::get("/category/fetch", "CategoryController@fetch")->name('admin.category.fetch');

    Route::post("/location/store", "LocationController@store")->name('admin.location.store');
    Route::get("/location/fetch", "LocationController@fetch")->name('admin.location.fetch');

    Route::post('/bank/store', "BankController@store");
    Route::post('/bank/update', "BankController@update");

    Route::get('/payments/fetch/{page}', "PaymentController@fetch");
    Route::post('/payments/update', "PaymentController@update");

    Route::get("/posts/fetch/{page}", "PostController@adminFetch");
    Route::post("/posts/delete", "PostController@adminDelete");

});