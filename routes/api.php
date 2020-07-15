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

Route::prefix('products')->name('products.')->group(function () {
    Route::post('/', 'ProductsController@storeProduct');
    Route::put('/', 'ProductsController@storeProduct');
    Route::get('/', 'ProductsController@getProducts');
    Route::get('/{id}', 'ProductsController@showProduct')->name('showProduct');
    Route::get('/recommended/{city}', 'ProductsController@recommendedProducts')->name('recommendedProducts');
    Route::delete('/{id}', 'ProductsController@deleteProduct');
});
