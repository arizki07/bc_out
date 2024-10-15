<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\BookingModel;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        $barang = BarangModel::all();
        return view('pages.landing', [
            'barang' => $barang,
        ]);
    }

    public function pesan()
    {
        $barang = BarangModel::all();
        return view('pages.booking', [
            'barang' => $barang,
        ]);
    }

    public function storeBooking(Request $request)
    {
        $request->validate([
            'customer' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
            'tgl_sewa' => 'required|date',
            'tgl_kembali' => 'required|date|after:tgl_sewa',
            'jaminan_sewa' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'barang_ids' => 'required|array',
            'barang_ids.*' => 'integer|exists:barang,id', // Pastikan setiap item yang dipilih ada
            'uang_dp' => 'nullable|numeric|min:0', // Memungkinkan null atau nilai numerik
        ]);

        if ($request->hasFile('jaminan_sewa')) {
            $jaminanSewa = $request->file('jaminan_sewa')->store('uploads/jaminan_sewa', 'public');
        } else {
            return redirect()->back()->withErrors(['jaminan_sewa' => 'File jaminan wajib diupload.']);
        }

        // Ambil item yang dipilih dari BarangModel
        $barangIds = $request->input('barang_ids');
        // Hitung total harga barang yang dipilih
        $totalBayar = BarangModel::whereIn('id', $barangIds)->sum('harga');

        // Buat booking
        BookingModel::create([
            'barang_id' => implode(',', $barangIds), // Simpan ID sebagai string yang dipisahkan koma
            'customer' => $request->input('customer'),
            'paket' => null, // Set paket menjadi null
            'no_hp' => $request->input('no_hp'),
            'alamat' => $request->input('alamat'),
            'tgl_sewa' => $request->input('tgl_sewa'),
            'tgl_kembali' => $request->input('tgl_kembali'),
            'jaminan_sewa' => $jaminanSewa,
            'uang_dp' => $request->input('uang_dp') ?: 0, // Simpan DP, default ke 0 jika null
            'total_bayar' => $totalBayar, // Simpan total harga dari barang yang dipilih
            'status' => 'Pending',
        ]);

        return redirect()->back()->with('success', 'Booking berhasil disimpan!');
    }






    public function paket()
    {
        $barangData = [
            "Paket A" => [1, 4, 13, 16],
            "Paket B" => [1, 6, 7, 13],
            "Paket C" => [1, 4, 13, 7, 8],
            "Paket D" => [19, 20, 6, 7, 22],
            "Paket E" => [19, 20, 23],
            "Paket F" => [24, 25, 27]
        ];

        $hargaPaket = [
            "Paket A" => '80k',
            "Paket B" => '60k',
            "Paket C" => '90k',
            "Paket D" => '55k',
            "Paket E" => '40k',
            "Paket F" => '40k'
        ];

        $paketBarang = [];
        foreach ($barangData as $paket => $barangIds) {
            $paketBarang[$paket] = BarangModel::whereIn('id', $barangIds)->get();
        }

        return view('pages.paket', compact('paketBarang', 'hargaPaket'));
    }

    public function storePaket(Request $request)
    {
        $request->validate([
            'customer' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'alamat' => 'required|string|max:255',
            'tgl_sewa' => 'required|date',
            'tgl_kembali' => 'required|date|after:tgl_sewa',
            'jaminan_sewa' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'paket' => 'required|string',
        ]);

        if ($request->hasFile('jaminan_sewa')) {
            $jaminanSewa = $request->file('jaminan_sewa')->store('uploads/jaminan_sewa', 'public');
        } else {
            return redirect()->back()->withErrors(['jaminan_sewa' => 'File jaminan wajib diupload.']);
        }

        $barangData = [
            "Paket A" => [1, 4, 13, 16],
            "Paket B" => [1, 6, 7, 13],
            "Paket C" => [1, 4, 13, 7, 8],
            "Paket D" => [19, 20, 6, 7, 22],
            "Paket E" => [19, 20, 23],
            "Paket F" => [24, 25, 27]
        ];

        $hargaPaket = [
            "Paket A" => 80000,
            "Paket B" => 60000,
            "Paket C" => 90000,
            "Paket D" => 55000,
            "Paket E" => 40000,
            "Paket F" => 40000
        ];

        $paket = $request->input('paket');

        if (!array_key_exists($paket, $barangData)) {
            return redirect()->back()->withErrors(['paket' => 'Paket tidak valid.']);
        }

        $barangIds = $barangData[$paket];
        $barangIdsString = implode(',', $barangIds);

        BookingModel::create([
            'barang_id' => $barangIdsString,
            'customer' => $request->input('customer'),
            'paket' => $paket,
            'no_hp' => $request->input('no_hp'),
            'alamat' => $request->input('alamat'),
            'tgl_sewa' => $request->input('tgl_sewa'),
            'tgl_kembali' => $request->input('tgl_kembali'),
            'jaminan_sewa' => $jaminanSewa,
            'uang_dp' => null,
            'total_bayar' => $hargaPaket[$paket],
            'status' => 'Pending'
        ]);


        $curl = curl_init();
        $barangNames = [];
        foreach ($barangIds as $id) {
            $barang = BarangModel::find($id);
            if ($barang) {
                $barangNames[] = $barang->nama_barang;
            }
        }

        $barangNamesString = implode(', ', $barangNames);

        $token = 'JhK9yFY6J+ewT1gvY9Jd';
        $whatsappNumber = $request->input('no_hp');
        $message = "Hallo {$request->input('customer')} 👋,\n\n"
            . "Terima kasih telah memilih Semesta Outdoor untuk kebutuhan penyewaan barang outdoor Anda! 🎒✨\n"
            . "No Hp: {$whatsappNumber}\n"
            . "Alamat: {$request->input('alamat')}\n"
            . "Tanggal Sewa: {$request->input('tgl_sewa')}\n"
            . "Tanggal Kembali: {$request->input('tgl_kembali')}\n"
            . "Uang DP: Belum dibayarkan\n"
            . "Barang yang dipesan: {$barangNamesString}\n"
            . "Paket: {$paket}\n"
            . "Total Pembayaran: Rp. {$hargaPaket[$paket]}\n\n"
            . "Anda dapat menghubungi admin kami untuk melanjutkan proses transaksi atau jika ada pertanyaan lebih lanjut.
            Terima kasih atas kepercayaan Anda dan selamat berpetualang bersama Semesta Outdoor! 🌍🌲\n\n";

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => [
                'target' => $whatsappNumber,
                'message' => $message
            ],
            CURLOPT_HTTPHEADER => [
                'Authorization: ' . $token
            ],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        if ($response) {
            return redirect()->back()->with('success', 'Booking berhasil disimpan dan pesan WhatsApp telah dikirim!');
        } else {
            return redirect()->back()->with('error', 'Booking berhasil disimpan, tetapi gagal mengirim pesan WhatsApp.');
        }
    }
}
