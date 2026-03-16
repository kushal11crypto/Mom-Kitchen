<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
});



Route::get('/dashboard', function () {

    if(auth()->user()->role == 'vendor'){
        return redirect()->route('vendor.dashboard');
    }

    if(auth()->user()->role == 'customer'){
        return redirect()->route('customer.dashboard');
    }

    abort(403);

})->middleware(['auth','verified'])->name('dashboard');


Route::middleware(['auth','role:vendor'])->group(function () {

    Route::get('/vendor/dashboard', function () {
        return view('vendor.dashboard');
    })->name('vendor.dashboard');

});

Route::middleware(['auth','role:customer'])->group(function () {

    Route::get('/customer/dashboard', function () {
        return view('customer.dashboard');
    })->name('customer.dashboard');

});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});