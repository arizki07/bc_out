<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Testing product',
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'kategori' => 'required',
            'stock' => 'required|integer',
            'foto' => 'nullable|image|mimes:png,jpg,jpeg|max:2048', // max diubah ke 2048 kilobytes (2MB)
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 400);
        }

        // Mengambil semua input dari request
        $input = $request->all();

        // Menangani upload file
        if ($request->hasFile('foto')) {
            // Simpan file ke storage (otomatis ke folder 'storage/app/public/products')
            $path = $request->file('foto')->store('products', 'public');

            // Simpan nama file yang diupload ke dalam input array
            $input['foto'] = basename($path);
        } else {
            $input['foto'] = null; // Atur nilai foto menjadi null jika tidak ada file yang diupload
        }

        // Simpan data produk ke database
        $product = ProductModel::create($input);

        // Mengembalikan response sukses
        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => $product,
        ], 201);
    }
}
