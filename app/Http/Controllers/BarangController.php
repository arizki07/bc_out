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
            'nama_barang' => 'required|string',
            'stok' => 'required|integer',
            'harga' => 'required|numeric',
            'status' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi foto
        ]);

        // Generate a random filename
        $filename = uniqid() . '.' . $request->file('foto')->extension();

        // Store the file
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->storeAs('images', $filename, 'public');
        } else {
            $path = null; // atau handle jika foto tidak diupload
        }

        // Simpan data ke database
        BarangModel::create([
            'nama_barang' => $request->nama_barang,
            'stok' => $request->stok,
            'harga' => $request->harga,
            'status' => $request->status,
            'foto' => $filename, // Simpan nama file acak ke database
        ]);

        return response()->json(['message' => 'Data berhasil disimpan!'], 201);
    }


    public function getbarang()
    {
        $barang = BarangModel::all();
        return response()->json($barang);
    }
}
