<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentController;


// Default welcome page
Route::get('/', function () {
    return view('welcome');
});

// ==================== Web Pages for Customers ====================
// Example: List customers page
Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');

// Example: Add customer page
Route::get('/customers/create', function() {
    return view('customers.create');
})->name('customers.create');

// ==================== Web Pages for Items ====================
// Example: List items page
Route::get('/items', [ItemController::class, 'index'])->name('items.index');

// Example: Add item page
Route::get('/items/create', function() {
    return view('items.create');
})->name('items.create');

// ==================== Web Pages for Categories ====================
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', function() {
    return view('categories.create');
})->name('categories.create');

// ==================== Web Pages for Orders ====================
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/create', function() {
    return view('orders.create');
})->name('orders.create');

// ==================== Web Pages for Payments ====================
Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
Route::get('/payments/create', function() {
    return view('payments.create');
})->name('payments.create');
