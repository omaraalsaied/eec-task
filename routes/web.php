<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PharmacyController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ProductController::class, 'index'])->name('home');

Route::resource('products', ProductController::class);

Route::resource('pharmacies', PharmacyController::class);

Route::get('/search', [ProductController::class, 'search'])->name('products.search');

Route::group(['prefix' => 'pharmacies'], function () {
    Route::post('{pharmacy}/add-product', [PharmacyController::class, 'addProduct'])->name('pharmacies.add-product');
    Route::post('{pharmacy}/remove-product', [PharmacyController::class, 'removeProduct'])->name('pharmacies.remove-product');
    Route::patch('{pharmacy}/products/{product}/update-price', [PharmacyController::class, 'updateProductPrice'])->name('pharmacies.update-product-price');

});


