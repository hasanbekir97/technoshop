<?php

use App\Http\Controllers\api\BrandApi;
use App\Http\Controllers\api\CategoryApi;
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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/



Route::group(['middleware' => 'authApi'], function () {

    //Api processes for brands
    Route::get('brands', [BrandApi::class, "index"]);
    Route::get('brands/{brand}', [BrandApi::class, "show"]);
    Route::post('brands', [BrandApi::class, "store"]);
    Route::put('brands/{brand}', [BrandApi::class, "update"]);
    Route::delete('brands/{brand}', [BrandApi::class, "delete"]);

    //Api processes for categories
    Route::get('categories', [CategoryApi::class, "index"]);
    Route::get('categories/{category}', [CategoryApi::class, "show"]);
    Route::post('categories', [CategoryApi::class, "store"]);
    Route::put('categories/{category}', [CategoryApi::class, "update"]);
    Route::delete('categories/{category}', [CategoryApi::class, "delete"]);

    //Api processes for order
    /*Route::get('orders', [OrderApi::class, "index"]);
    Route::get('orders/{order}', [OrderApi::class, "show"]);*/

});

