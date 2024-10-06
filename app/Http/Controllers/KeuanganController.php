<?php

namespace App\Http\Controllers;

use App\Models\PendapatanModel;
use App\Models\PengeluaranModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KeuanganController extends Controller
{
    public function storePendapatan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keterangan' => 'required',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $pendapatan = new PendapatanModel();
        $pendapatan->keterangan = $request->input('keterangan');
        $pendapatan->jumlah = $request->input('jumlah');
        $pendapatan->tanggal = $request->input('tanggal');
        $pendapatan->save();

        return response()->json([
            'success' => true,
            'message' => 'Pendapatan created successfully',
            'data' => $pendapatan
        ], 201);
    }

    // Menyimpan Pengeluaran
    public function storePengeluaran(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'keterangan' => 'required',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        $pengeluaran = new PengeluaranModel();
        $pengeluaran->keterangan = $request->input('keterangan');
        $pengeluaran->jumlah = $request->input('jumlah');
        $pengeluaran->tanggal = $request->input('tanggal');
        $pengeluaran->save();

        return response()->json([
            'success' => true,
            'message' => 'Pengeluaran created successfully',
            'data' => $pengeluaran
        ], 201);
    }
}
