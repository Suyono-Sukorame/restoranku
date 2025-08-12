<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('admin.dashboard'); // sesuaikan dengan view dashboard kamu
})->name('dashboard');

Route::resource('orders', OrderController::class)->names('orders');
Route::resource('items', ItemController::class)->names('items');
Route::resource('users', UserController::class)->names('users');
Route::resource('roles', RoleController::class)->names('roles');
Route::resource('categories', CategoryController::class)->names('categories');


// Route::resource('categories', CategoryController::class)->names('admin.categories');
// Route::resource('items', CategoryController::class)->names('admin.items');
// Route::resource('roles', CategoryController::class)->names('admin.roles');
// Route::resource('users', CategoryController::class)->names('admin.users');
// Route::resource('orders', CategoryController::class)->names('admin.orders');


