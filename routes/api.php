<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(DashboardController::class)->group(function () {

    Route::get('home', 'home');
    Route::get('products-by-brand/{brand}', 'products_by_brand');

});