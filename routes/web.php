<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Root Controllers
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PaymentController;

// Admin Controllers (Inside Admin Folder)
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Role-Based Redirect Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    if ($role === 'vendor') {
        return redirect()->route('vendor.dashboard');
    }
    if ($role === 'customer') {
        return redirect()->route('customer.menu');
    }

    abort(403);
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes (Prefix: admin. | URL: /admin/...)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', AdminUserController::class);
    Route::resource('categories', AdminCategoryController::class);
    
    // Payment Management
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::patch('/payments/{payment}/status', [PaymentController::class, 'updateStatus'])->name('payments.updateStatus');
});

Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    
    Route::get('/dashboard', function () {
        // Fetch items from the database
        // Assuming your Item model has a 'user_id' to identify which vendor owns it
        $items = \App\Models\Item::where('user_id', auth()->id())->get();

        // Pass the items to the view
        return view('vendor.dashboard', compact('items'));
    })->name('dashboard');

    Route::resource('items', ItemController::class);

     Route::get('/orders', [OrderController::class, 'vendorOrders'])->name('orders.index');

    Route::get('/orders/{id}', [OrderController::class, 'vendorOrderShow'])->name('orders.show');

    // Earnings / Transactions (NEW)
    Route::get('/transactions', [PaymentController::class, 'vendorTransactions'])->name('transactions.index');
});

Route::middleware(['auth', 'role:customer'])->group(function () {
    // Menu & Profile
    Route::get('/customer/menu', [ItemController::class, 'menu'])->name('customer.menu');
    Route::get('/customer/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/customer/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/customer/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/customer/orders', [OrderController::class, 'myOrders'])->name('customer.orders');
    Route::get('/customer/orders/{id}', [OrderController::class, 'showOrder'])
         ->name('customer.orders.show');


    // Cart & Checkout
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add.to.cart');
    Route::post('/cart/increase/{id}', [CartController::class, 'increase'])->name('cart.increase');
    Route::post('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('place.order');
    Route::get('/payment/verify', [OrderController::class, 'verifyPayment'])->name('payment.verify');
});