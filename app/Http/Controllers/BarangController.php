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
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'status' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Mengubah menjadi nullable
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        // Jika ada file foto yang diunggah
        if ($request->hasFile('foto')) {
            // Rename the file to a unique name to avoid overwriting
            $foto = $request->file('foto')->store('barang/', 'public');
        } else {
            $foto = null; // Foto nullable, jadi bisa null
        }

        // Menyimpan data barang ke database
        $barang = new BarangModel();
        $barang->nama_barang = $request->input('nama_barang');
        $barang->stok = $request->input('stok');
        $barang->harga = $request->input('harga');
        $barang->status = $request->input('status');
        $barang->foto = $foto; // Menyimpan foto yang nullable
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
