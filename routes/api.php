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
Route::get('categories/fetch', 'HomeController@fetchCategories');

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');

Route::post('/post/store', 'PostController@store');

Route::get('/checkUser', 'AuthController@getAuthenticatedUser');

Route::prefix('admin')->group(function (){

    Route::post("/category/store", "CategoryController@store")->name('admin.category.store');
    Route::get("/category/fetch", "CategoryController@fetch")->name('admin.category.fetch');

    Route::post("/location/store", "LocationController@store")->name('admin.location.store');
    Route::get("/location/fetch", "LocationController@fetch")->name('admin.location.fetch');

});