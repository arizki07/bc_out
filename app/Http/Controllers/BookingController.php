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

    public function index()
    {
        return view('pages.booking', []);
    }

    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'paket1' => 'required|string',
            'paket2' => 'required|string',
            'customer' => 'required|string',
            'no_hp' => 'required|string',
            'alamat' => 'required|string',
            'tgl_sewa' => 'required|date',
            'tgl_kembali' => 'required|date',
            'jaminan_sewa' => 'required|string',
            'uang_dp' => 'nullable|string',
            'total_bayar' => 'required|string',
        ]);

        // Mengurangi stok barang
        $barangIds = array_merge($this->getBarangIds($validatedData['paket1']), $this->getBarangIds($validatedData['paket2']));

        foreach ($barangIds as $barangId) {
            $barang = BarangModel::find($barangId);
            if ($barang && $barang->stok > 0) {
                $barang->stok -= 1; // Mengurangi stok
                $barang->save();
            }
        }

        // Membuat pemesanan
        BookingModel::create([
            'paket' => $validatedData['paket1'] . ', ' . $validatedData['paket2'], // Menggabungkan paket yang dipilih
            'customer' => $validatedData['customer'],
            'no_hp' => $validatedData['no_hp'],
            'alamat' => $validatedData['alamat'],
            'tgl_sewa' => $validatedData['tgl_sewa'],
            'tgl_kembali' => $validatedData['tgl_kembali'],
            'jaminan_sewa' => $validatedData['jaminan_sewa'],
            'uang_dp' => $validatedData['uang_dp'],
            'total_bayar' => $validatedData['total_bayar'],
            'status' => 'belum', // Atau sesuaikan dengan logika Anda
        ]);

        return redirect()->back()->with('success', 'Pemesan telah berhasil dibuat.');
    }

    private function getBarangIds($paket)
    {
        $barangData = [
            "Paket A" => [1, 4, 13, 16],
            "Paket B" => [1, 6, 7, 13],
            "Paket C" => [1, 4, 13, 7, 8],
            "Paket D" => [19, 20, 6, 7, 22],
            "Paket E" => [19, 20, 23],
            "Paket F" => [24, 25, 27]
        ];

        return $barangData[$paket] ?? [];
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'barang_id' => 'required|exists:barang,id',
    //         'customer' => 'required|string',
    //         'no_hp' => 'required|string',
    //         'alamat' => 'required|string',
    //         'tgl_sewa' => 'required|date',
    //         'tgl_kembali' => 'required|date',
    //         'jaminan_sewa' => 'required|file|mimes:jpg,png,jpeg|max:2048',
    //         'uang_dp' => 'nullable|string',
    //     ]);

    //     $filePath = $request->file('jaminan_sewa')->store('jaminan_files', 'public');

    //     $status = $request->uang_dp ? 'belum' : 'lunas';

    //     $booking = BookingModel::create([
    //         'barang_id' => $validated['barang_id'],
    //         'customer' => $validated['customer'],
    //         'no_hp' => $validated['no_hp'],
    //         'alamat' => $validated['alamat'],
    //         'tgl_sewa' => $validated['tgl_sewa'],
    //         'tgl_kembali' => $validated['tgl_kembali'],
    //         'jaminan_sewa' => $filePath,
    //         'uang_dp' => $validated['uang_dp'],
    //         'status' => $status,
    //         'total_bayar' => null,
    //     ]);


    //     $token = 'CDxpA_hWBv16LamrRZok';
    //     $whatsappNumber = '081312211348';
    //     $barang = BarangModel::find($validated['barang_id']);

    //     $message = "Pemesanan berhasil dilakukan!\n\n"
    //         . "Nama Customer: {$validated['customer']}\n"
    //         . "No Hp: {$validated['no_hp']}\n"
    //         . "Alamat: {$validated['alamat']}\n"
    //         . "Tanggal Sewa: {$validated['tgl_sewa']}\n"
    //         . "Tanggal Kembali: {$validated['tgl_kembali']}\n"
    //         . "Uang DP: {$validated['uang_dp']}\n"
    //         . "Barang yang dipesan: {$barang->nama_barang}\n\n"
    //         . "Terima kasih telah melakukan pemesanan!";


    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //         CURLOPT_URL => 'https://api.fonnte.com/send',
    //         CURLOPT_RETURNTRANSFER => true,
    //         CURLOPT_ENCODING => '',
    //         CURLOPT_MAXREDIRS => 10,
    //         CURLOPT_TIMEOUT => 0,
    //         CURLOPT_FOLLOWLOCATION => true,
    //         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //         CURLOPT_CUSTOMREQUEST => 'POST',
    //         CURLOPT_POSTFIELDS => array('target' => $whatsappNumber, 'message' => $message),
    //         CURLOPT_HTTPHEADER => array(
    //             'Authorization: ' . $token
    //         ),
    //     ));

    //     $response = curl_exec($curl);

    //     curl_close($curl);

    //     return response()->json(['success' => true, 'message' => 'Booking saved and notification sent.']);
    // }



    // public function store(Request $request)
    // {
    //     // Validasi input
    //     $validator = Validator::make($request->all(), [
    //         'barang_id' => 'required|exists:barang,id',
    //         'customer' => 'required|string|max:255',
    //         'alamat' => 'required|string|max:255',
    //         'tgl_sewa' => 'required|date|date_format:Y-m-d',
    //         'tgl_kembali' => 'required|date|after:tgl_sewa|date_format:Y-m-d',
    //         'jaminan_sewa' => 'required|string|max:255',
    //         'uang_dp' => 'nullable|numeric',
    //         'total_bayar' => 'nullable|numeric',
    //         'status' => 'required|in:lunas,belum',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 422);
    //     }

    //     // Mencari barang berdasarkan id
    //     $barang = BarangModel::find($request->barang_id);

    //     if (!$barang) {
    //         return response()->json(['error' => 'Barang tidak ditemukan'], 404);
    //     }

    //     // Hitung total bayar (Misal menggunakan harga barang)
    //     // Sesuaikan logika ini dengan kebutuhan bisnis Anda
    //     // $totalBayar = $barang->harga; // Misalnya harga tetap barang

    //     // Buat booking baru
    //     $booking = BookingModel::create([
    //         'barang_id' => $request->barang_id,
    //         'customer' => $request->customer,
    //         'alamat' => $request->alamat,
    //         'tgl_sewa' => $request->tgl_sewa,
    //         'tgl_kembali' => $request->tgl_kembali,
    //         'jaminan_sewa' => $request->jaminan_sewa,
    //         'uang_dp' => $request->uang_dp,
    //         'total_bayar' => $request->total_bayar,
    //         'status' => $request->status,
    //     ]);

    //     // Jika status sudah lunas, set uang dp menjadi null
    //     if ($request->status === 'lunas') {
    //         $booking->update(['uang_dp' => null]);
    //     }

    //     return response()->json($booking, 201);
    // }
}
