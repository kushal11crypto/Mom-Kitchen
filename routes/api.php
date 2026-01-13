<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PaymentController;


// ==================== Item Routes ====================
Route::get('/items', [ItemController::class, 'index']);      // List all items
Route::post('/items', [ItemController::class, 'store']);     // Create item
Route::get('/items/{id}', [ItemController::class, 'show']);  // Get single item
Route::put('/items/{id}', [ItemController::class, 'update']); // Update item
Route::delete('/items/{id}', [ItemController::class, 'destroy']); // Delete item

// ==================== Order Routes ====================
Route::get('/orders', [OrderController::class, 'index']);    // List all orders
Route::post('/orders', [OrderController::class, 'store']);   // Create order
Route::get('/orders/{id}', [OrderController::class, 'show']); // Get single order
Route::put('/orders/{id}', [OrderController::class, 'update']); // Update order
Route::delete('/orders/{id}', [OrderController::class, 'destroy']); // Delete order

// ==================== Customer Routes ====================
Route::get('/customers', [CustomerController::class, 'index']);      // List all customers
Route::post('/customers', [CustomerController::class, 'store']);     // Create customer
Route::get('/customers/{id}', [CustomerController::class, 'show']);  // Get single customer
Route::put('/customers/{id}', [CustomerController::class, 'update']); // Update customer
Route::delete('/customers/{id}', [CustomerController::class, 'destroy']); // Delete cus
