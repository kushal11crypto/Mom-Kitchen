<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ItemController;

require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
});



Route::get('/dashboard', function () {

    if(auth()->user()->role == 'vendor'){
        return redirect()->route('vendor.dashboard');
    }

    if(auth()->user()->role == 'customer'){
        return redirect()->route('customer.menu');
    }

    abort(403);

})->middleware(['auth','verified'])->name('dashboard');


Route::middleware(['auth','role:vendor'])->group(function () {

    Route::get('/vendor/dashboard', function () {
        return view('vendor.dashboard');
    })->name('vendor.dashboard');

});

Route::middleware(['auth','role:customer'])->group(function () {

    Route::get('/customer/menu', function () {
        return view('customer.menu');
    })->name('customer.menu');

});

// Customer Profile Routes
Route::middleware(['auth', 'role:customer'])->group(function () {
    // Show profile page
    Route::get('/customer/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // Update profile
    Route::patch('/customer/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Delete account
    Route::delete('/customer/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/customer/orders', [OrderController::class, 'myOrders'])->name('customer.orders');
});

Route::post('/add-to-cart', function (Request $request) {
    $product = $request->validate([
        'name' => 'required|string',
        'price' => 'required|numeric',
        'image' => 'required|string',
    ]);

    $cart = session()->get('cart', []);

    // Generate a unique key for each item (or use product name)
    $itemKey = $product['name'];

    // If item exists, increase quantity
    if(isset($cart[$itemKey])) {
        $cart[$itemKey]['quantity'] += 1;
    } else {
        $cart[$itemKey] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image'],
            'quantity' => 1,
        ];
    }

    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Item added to cart!');
});

Route::get('/customer/menu', [ItemController::class, 'menu'])->name('customer.menu');

Route::get('/cart', function () {
    $cart = session('cart', []);
    return view('cart', compact('cart'));
});

Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add.to.cart');
Route::post('/cart/increase/{id}', [CartController::class, 'increase'])->name('cart.increase');
Route::post('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/place-order', [OrderController::class, 'placeOrder'])->name('place.order');
Route::get('/payment/verify', [OrderController::class, 'verifyPayment'])->name('payment.verify');



Route::middleware(['auth'])->group(function () {
    Route::get('/vendor/dashboard', [ItemController::class, 'dashboard'])->name('vendor.dashboard');

    Route::get('/vendor/create-item', [ItemController::class, 'create'])->name('items.create');
    Route::post('/items/store', [ItemController::class, 'store'])->name('items.store');

    Route::get('/items/edit/{id}', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/update/{id}', [ItemController::class, 'update'])->name('items.update');

    Route::delete('/items/delete/{id}', [ItemController::class, 'destroy'])->name('items.destroy');
});