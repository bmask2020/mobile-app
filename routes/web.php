<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;


Route::get('/', function () {
    return redirect()->route('login');
});



Route::controller(DashboardController::class)->group(function () {
 
    Route::any('/admin-login', 'admin_login')->name('admin.login');
    Route::any('/admin-forget-password', 'admin_forget_password')->name('admin.forget.password');
    Route::get('/admin-reset-password/{id}', 'admin_reset_password')->name('admin.reset.password');
    Route::any('/admin-update-password', 'admin_update_password')->name('admin.forget.update');

    Route::middleware(['auth', 'verified','role:admin'])->group(function () {

        Route::get('/dashboard', 'dashboard')->name('dashboard');
    });
    
});


Route::controller(BrandController::class)->group(function () {

    Route::middleware(['auth', 'verified','role:admin'])->group(function () {

        Route::get('/add-brand', 'add_brand')->name('add.brand');
        Route::any('/store-brand', 'store_brand')->name('store.brand');
        Route::get('/view-brand', 'view_brand')->name('view.brand');
        Route::get('/edit-brand/{id}', 'edit_brand')->name('edit.brand');
        Route::any('/update-brand', 'update_brand')->name('update.brand');
        Route::get('/delete-brand/{id}', 'delete_brand')->name('delete.brand');
        
    });

});


Route::controller(ProductController::class)->group(function () {

    Route::middleware(['auth', 'verified','role:admin'])->group(function () {

        Route::get('/add-product', 'add_product')->name('add.product');
        Route::any('/store-product', 'store_product')->name('store.product');
        Route::get('/view-products', 'view_products')->name('view.products');
        Route::get('/edit-products/{id}', 'edit_product')->name('edit.product');
        Route::any('/update-product', 'update_product')->name('update.product');
        Route::get('/delete-product/{id}', 'delete_product')->name('delete.product');
        
    });

});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
