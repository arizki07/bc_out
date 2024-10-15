<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/testing', function () {
    return response([
        'message' => 'Testing api jos',
    ]);
}, 200);

Route::post('/register', [AuthController::class, 'registered']);
Route::post('/login', [AuthController::class, 'authenticate']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::post('barang', [BarangController::class, 'store']);
Route::get('/getBarang', [BarangController::class, 'getbarang']);
Route::post('/pendapatan', [KeuanganController::class, 'storePendapatan']);
Route::post('/pengeluaran', [KeuanganController::class, 'storePengeluaran']);
Route::get('/total-bayar', [KeuanganController::class, 'getTotalBayar']);
Route::get('/getbooking', [BookingController::class, 'getBooking']);
Route::put('/bookings/{id}', [BookingController::class, 'update']);
