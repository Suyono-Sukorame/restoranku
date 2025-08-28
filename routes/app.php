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
Route::get('/cart/count', [MenuController::class, 'cartCount'])->name('cart.count');
Route::get('/cara-pesan', fn() => view('qr-info'))->name('qr.info');

// Contact Routes
Route::get('/kontak', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/kontak/send', [App\Http\Controllers\ContactController::class, 'send'])->name('contact.send');

// QR Code Routes (Admin only)
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin/qr', [App\Http\Controllers\QRController::class, 'listTables'])->name('qr.list');
    Route::get('/admin/qr/meja/{tableNumber}', [App\Http\Controllers\QRController::class, 'generateTable'])->name('qr.generate');
    
    // Expense & Report Routes
    Route::resource('expenses', App\Http\Controllers\ExpenseController::class);
    Route::get('reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    
    // Inventory Routes
    Route::resource('inventories', App\Http\Controllers\InventoryController::class);
    Route::post('inventories/{inventory}/restock', [App\Http\Controllers\InventoryController::class, 'restock'])->name('inventories.restock');
    
    // Customer Management Routes
    Route::get('customers', [App\Http\Controllers\CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{customer}', [App\Http\Controllers\CustomerController::class, 'show'])->name('customers.show');
    Route::get('customer-feedback', [App\Http\Controllers\CustomerController::class, 'feedback'])->name('customers.feedback');
    
    // Table Management Routes
    Route::get('tables', [App\Http\Controllers\TableController::class, 'index'])->name('tables.index');
    Route::put('tables/{table}/status', [App\Http\Controllers\TableController::class, 'updateStatus'])->name('tables.updateStatus');
    
    // Kitchen Display Routes
    Route::get('kitchen', [App\Http\Controllers\KitchenController::class, 'index'])->name('kitchen.index');
    Route::put('kitchen/{order}/status', [App\Http\Controllers\KitchenController::class, 'updateStatus'])->name('kitchen.updateStatus');
    
    // Receipt Routes
    Route::get('receipt/{order}', [App\Http\Controllers\ReceiptController::class, 'show'])->name('receipt.show');
    Route::get('receipt/{order}/print', [App\Http\Controllers\ReceiptController::class, 'print'])->name('receipt.print');
    
    // Backup Routes
    Route::get('backup', [App\Http\Controllers\BackupController::class, 'index'])->name('backup.index');
    Route::get('backup/create', [App\Http\Controllers\BackupController::class, 'create'])->name('backup.create');
    Route::get('backup/download/{filename}', [App\Http\Controllers\BackupController::class, 'download'])->name('backup.download');
    Route::delete('backup/{filename}', [App\Http\Controllers\BackupController::class, 'delete'])->name('backup.delete');
    Route::post('backup/restore', [App\Http\Controllers\BackupController::class, 'restore'])->name('backup.restore');
});

// API Routes for notifications
Route::get('/api/check-new-orders', [App\Http\Controllers\NotificationController::class, 'checkNewOrders']);
Route::post('/api/send-whatsapp', [App\Http\Controllers\NotificationController::class, 'sendWhatsApp']);

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
    

