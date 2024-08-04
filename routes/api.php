<?php

use App\Http\Controllers\api\v1\PharmacyController;
use App\Http\Controllers\api\v1\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::resource('products', ProductController::class);
    Route::post('products/search', [ProductController::class, 'search']);


    Route::resource('pharmacies', PharmacyController::class);

    Route::group(['prefix' => 'pharmacies'], function () {
        Route::post('{pharmacy}/add-product', [PharmacyController::class, 'addProduct']);
        Route::post('{pharmacy}/remove-product', [PharmacyController::class, 'removeProduct']);
        Route::patch('{pharmacy}/products/{product}/update-price', [PharmacyController::class, 'updateProductPrice']);
        Route::get('/{pharmacy}/available-products', [PharmacyController::class, 'getAvailableProducts']);
    });

});
