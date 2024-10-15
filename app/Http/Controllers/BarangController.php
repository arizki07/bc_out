<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illumintae\Support\Str;

class BarangController extends Controller
{

    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta'); // Correctly set the timezone
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'status' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk foto
        ]);

        // Menyimpan foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            // Generate unique file name
            $fileName = Str::random(10) . '.' . $request->file('foto')->getClientOriginalExtension(); // Contoh: abc1234567.jpg
            $fotoPath = $request->file('foto')->storeAs('images/barang', $fileName, 'public'); // Simpan di storage/app/public/images/barang
        }

        // Simpan data barang ke database
        $barang = BarangModel::create([
            'nama_barang' => $request->nama_barang,
            'stok' => $request->stok,
            'harga' => $request->harga,
            'status' => $request->status,
            'foto' => $fileName, // Simpan hanya nama file
        ]);

        return response()->json([
            'message' => 'Data barang berhasil disimpan!',
            'data' => $barang,
        ], 201);
    }

    public function getbarang()
    {
        $barang = BarangModel::all();
        return response()->json($barang);
    }
}
