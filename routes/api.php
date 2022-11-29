<?php

use App\Http\Controllers\ProductsController;
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

Route::group(['middleware' => ['auth:sanctum']] , function () {
    Route::controller(ProductsController::class)->group(function() {
        Route::get('products', 'index');
        Route::get('products/{id}', 'show');
        Route::post('products/create', 'store');
        Route::put('products/update/{id}', 'update');
        Route::delete('products/delete/{id}', 'destroy');
    });
});
