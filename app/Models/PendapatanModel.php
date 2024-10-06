<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendapatanModel extends Model
{
    use HasFactory;
    protected $table = 'pendapatan';

    protected $fillable = [
        'keterangan',
        'jumlah',
        'tanggal',
    ];
}
