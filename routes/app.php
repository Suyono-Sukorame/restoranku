<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
// use App\Models\Category;
use Illuminate\Support\Facades\Route;

// Frontend
Route::get('/', fn() => redirect()->route('menu'));
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/cart', [MenuController::class, 'cart'])->name('cart');
Route::post('/cart/add', [MenuController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [MenuController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove/{id}', [MenuController::class, 'removeCart'])->name('cart.remove');
Route::get('/cart/clear', [MenuController::class, 'clearCart'])->name('cart.clear');
Route::get('/checkout', [MenuController::class, 'checkout'])->name('checkout');
Route::post('/checkout/store', [MenuController::class, 'storeOrder'])->name('checkout.store');
Route::get('checkout/success/{orderId}', [MenuController::class, 'checkoutSuccess'])->name('checkout.success');

// Backend Admin
Route::middleware(['role:admin'])->group(function () {
    Route::resource('categories', CategoryController::class)->names('categories');
    Route::resource('items', ItemController::class)->names('items');
    Route::resource('roles', RoleController::class)->names('roles');
    Route::resource('users', UserController::class)->names('users');
});

Route::middleware(['role:admin|cashier'])->group(function () {
    Route::post('orders/settlement/{order}', [OrderController::class, 'settlement'])->name('orders.settlement');
});

Route::middleware(['role:chef'])->group(function () {
    Route::post('orders/cooked/{order}', [OrderController::class, 'cooked'])->name('orders.cooked');
});

Route::middleware(['role:admin|cashier|chef'])->group(function () {
    Route::resource('orders', OrderController::class)->names('orders');
    Route::get('dashboard', [DashboardController::class, 'index'])-> name('dashboard');
    Route::post('/items/update-status/{order}', [ItemController::class, 'updateStatus'])->name('items.update.status');
    Route::post('orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update.status');
});
    

