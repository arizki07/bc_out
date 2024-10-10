<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookingController::class, 'index']);
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
