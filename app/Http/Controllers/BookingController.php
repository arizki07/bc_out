<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\BookingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta'); // Correctly set the timezone
    }

    public function getBooking()
    {
        $booking = BookingModel::all();

        // Mengambil data barang, misalnya dari tabel barang
        $barang = DB::table('barang')->select('id', 'nama_barang')->get(); // Sesuaikan dengan struktur tabel Anda

        return response()->json([
            'barang' => $barang,
            'booking' => $booking,
        ]);
    }

    public function index()
    {
        $barang = BarangModel::all();
        return view('pages.booking', [
            'judul' => 'SEMESTA OUTDOOR',
            'barang' => $barang,
        ]);
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'customer' => 'required|string',
            'no_hp' => 'required|string',
            'alamat' => 'required|string',
            'tgl_sewa' => 'required|date',
            'tgl_kembali' => 'required|date',
            'jaminan_sewa' => 'required|file|mimes:jpg,png,jpeg|max:2048', // File validation
            'uang_dp' => 'nullable|string',
        ]);

        $filePath = $request->file('jaminan_sewa')->store('jaminan_files', 'public');

        $status = $request->uang_dp ? 'belum' : 'lunas';

        $booking = BookingModel::create([
            'barang_id' => $validated['barang_id'],
            'customer' => $validated['customer'],
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'],
            'tgl_sewa' => $validated['tgl_sewa'],
            'tgl_kembali' => $validated['tgl_kembali'],
            'jaminan_sewa' => $filePath,
            'uang_dp' => $validated['uang_dp'],
            'status' => $status,
            'total_bayar' => null,
        ]);

        $token = 'JhK9yFY6J+ewT1gvY9Jd';
        $whatsappNumber = ($validated['no_hp']);
        $barang = BarangModel::find($validated['barang_id']);

        $message = "Hallo *{$validated['customer']}* 👋,\n\n"
            . "Terima kasih telah memilih *Semesta Outdoor* untuk kebutuhan penyewaan barang outdoor Anda! 🎒✨\n\n"
            . "Berikut detail pemesanan Anda:\n"
            . "📱 *No HP*: {$validated['no_hp']}\n"
            . "🏡 *Alamat*: {$validated['alamat']}\n"
            . "📅 *Tanggal Sewa*: {$validated['tgl_sewa']}\n"
            . "📅 *Tanggal Kembali*: {$validated['tgl_kembali']}\n"
            . "💵 *Uang DP*: " . ($validated['uang_dp'] ? "Rp {$validated['uang_dp']}" : "Belum dibayar") . "\n"
            . "📦 *Barang yang dipesan*: {$barang->nama_barang}\n\n"
            . "Anda dapat menghubungi admin kami untuk melanjutkan proses transaksi atau jika ada pertanyaan lebih lanjut.\n"
            . "Terima kasih atas kepercayaan Anda dan selamat berpetualang bersama *Semesta Outdoor*! 🌍🌲\n\n"
            . "*Salam Hangat*,\n"
            . "*Tim Semesta Outdoor*";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('target' => $whatsappNumber, 'message' => $message),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $token
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return response()->json(['success' => true, 'message' => 'Booking saved and notification sent.']);
    }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'uang_dp' => 'nullable|numeric', // Ensure it’s numeric
            'total_bayar' => 'required|numeric', // Ensure it’s numeric
        ]);

        // Return validation errors if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        // Find the booking by ID
        $booking = BookingModel::find($id);

        // Check if booking exists
        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found',
            ], 404);
        }

        // Update the fields
        $booking->uang_dp = $request->input('uang_dp');
        $booking->total_bayar = $request->input('total_bayar');

        // Save the changes
        $booking->save();

        // Return a successful response
        return response()->json([
            'success' => true,
            'message' => 'Booking updated successfully',
            'data' => $booking, // Optionally return the updated booking data
        ], 200);
    }
}
