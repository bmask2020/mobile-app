<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(DashboardController::class)->group(function () {

    Route::get('home', 'home');
    Route::get('products-by-brand/{brand}', 'products_by_brand');
    
    Route::get('product-view/{id}', 'products_view');

    Route::get('filters/{filter}', 'filters');

});


Route::controller(AuthController::class)->group(function () {


    Route::post('register', 'register');
    
});