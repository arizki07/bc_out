<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\BookingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta'); // Correctly set the timezone
    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'barang_id' => 'required|exists:barang,id',
            'customer' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'tgl_sewa' => 'required|date',
            'tgl_kembali' => 'required|date|after:tgl_sewa',
            'jaminan_sewa' => 'required|string|max:255',
            'uang_dp' => 'nullable|numeric',
            'total_bayar' => 'nullable|numeric',
            'status' => 'required|in:lunas,belum',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Mencari barang berdasarkan id
        $barang = BarangModel::find($request->barang_id);

        // Hitung total bayar tanpa memperhitungkan durasi sewa (misalnya menggunakan harga tetap)
        $totalBayar = $barang->harga; // Ganti dengan logika perhitungan yang sesuai

        // Buat booking baru
        $booking = BookingModel::create([
            'barang_id' => $request->barang_id,
            'customer' => $request->customer,
            'alamat' => $request->alamat,
            'tgl_sewa' => $request->tgl_sewa,
            'tgl_kembali' => $request->tgl_kembali,
            'jaminan_sewa' => $request->jaminan_sewa,
            'uang_dp' => $request->uang_dp,
            'total_bayar' => $totalBayar,
            'status' => $request->status,
        ]);

        // Jika status sudah lunas, set uang dp menjadi null
        if ($request->status === 'lunas') {
            $booking->update(['uang_dp' => null]);
        }

        return response()->json($booking, 201);
    }
}
