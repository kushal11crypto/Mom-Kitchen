<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PaymentController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| All routes here are protected by 'auth' and 'admin' middleware.
| Register AdminMiddleware in app/Http/Kernel.php under $routeMiddleware:
|   'admin' => \App\Http\Middleware\AdminMiddleware::class,
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Categories
    Route::resource('categories', CategoryController::class);

    // Items
    Route::resource('items', ItemController::class);
    Route::patch('items/{item}/toggle-availability', [ItemController::class, 'toggleAvailability'])
        ->name('items.toggle-availability');

    // Orders
    Route::resource('orders', OrderController::class)->except(['create', 'store', 'edit']);
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])
        ->name('orders.update-status');

    // Users
    Route::resource('users', UserController::class);

    // Payments
    Route::get('payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::patch('payments/{payment}/status', [PaymentController::class, 'updateStatus'])
        ->name('payments.update-status');

});