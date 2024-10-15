<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingModel extends Model
{
    use HasFactory;
    protected $table = 'booking';
    protected $fillable = [
        'barang_id',
        'customer',
        'paket',
        'no_hp',
        'alamat',
        'tgl_sewa',
        'tgl_kembali',
        'jaminan_sewa',
        'uang_dp',
        'total_bayar',
        'status',
    ];

    public function barang()
    {
        return $this->belongsTo(BarangModel::class, 'barang_id');
    }
}
