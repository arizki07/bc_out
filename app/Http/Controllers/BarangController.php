<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta'); // Correctly set the timezone
    }

    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_barang' => 'required',
            'stok' => 'required|integer',  // Tambahkan validasi integer untuk stok
            'harga' => 'required|numeric', // Tambahkan validasi numeric untuk harga
            'status' => 'required', // Validasi untuk status hanya bisa available/unavailable
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false, // Mengoreksi typo "succes"
                'message' => $validator->errors(),
            ], 400);
        }

        // Menyimpan data barang ke database
        $barang = new BarangModel();
        $barang->nama_barang = $request->input('nama_barang');
        $barang->stok = $request->input('stok');
        $barang->harga = $request->input('harga');
        $barang->status = $request->input('status');
        $barang->save(); // Simpan data ke database

        // Jika berhasil disimpan
        return response()->json([
            'success' => true,
            'message' => 'Barang created successfully',
            'data' => $barang // Menambahkan data barang yang disimpan
        ], 201);
    }

    public function getbarang()
    {
        $barang = BarangModel::all();
        return response()->json($barang);
    }
}
