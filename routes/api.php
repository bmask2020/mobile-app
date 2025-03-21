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

    Route::get('filters/{brand}/{filter}', 'filters_by_brand');

    Route::get('add-favorite/{product_id}', 'add_favorite')->middleware('auth:sanctum');

    Route::get('fetch-favorite','fetch_favorite')->middleware('auth:sanctum');

    Route::get('favorite-remove/{id}','remove_favorite')->middleware('auth:sanctum');

    Route::any('add-cart','add_cart')->middleware('auth:sanctum');

    Route::get('cart-fetch', 'cart_fetch')->middleware('auth:sanctum');

    Route::get('cart-remove/{id}', 'cart_remove')->middleware('auth:sanctum');

    Route::get('cart-remove-all', 'cart_remove_all')->middleware('auth:sanctum');

    Route::any('phone-verify', 'phone_verify')->middleware('auth:sanctum');
   
    Route::any('otp-verify', 'otp_verify');

    Route::get('create-orders', 'create_orders')->middleware('auth:sanctum');
    
    Route::get('authorised/{id}', 'authorised')->middleware('auth:sanctum');

    Route::get('declined/{id}', 'declined')->middleware('auth:sanctum');

    Route::get('cancelled/{id}', 'cancelled')->middleware('auth:sanctum');

    Route::get('orders-fetch', 'orders_fetch')->middleware('auth:sanctum');
    
    Route::any('live-chat', 'live_chat')->middleware('auth:sanctum');
    Route::any('live-chat/replay', 'live_chat_replay');

    Route::get('profile', 'profile')->middleware('auth:sanctum');
    Route::any('profile/update', 'profile_update')->middleware('auth:sanctum');
    
   
});


Route::controller(AuthController::class)->group(function () {

    Route::any('login', 'login');
    Route::post('register', 'register');
    Route::get('/logout', 'logout');
    
});