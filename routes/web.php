<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

// Route::get('/', [BookingController::class, 'index']);
// Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

Route::controller(LandingController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('booking', 'pesan');
    Route::get('paket', 'paket');
    Route::post('/paket/store', 'storePaket')->name('paket.store');
    Route::post('/booking/store', 'storeBooking')->name('booking.store');
});

// Route::controller(BookingController::class)->group(function () {
//     Route::post('/booking', 'store')->name('booking.store');
// });
