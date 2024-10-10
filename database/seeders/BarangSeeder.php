<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('barang')->insert([
            [
                'nama_barang' => 'Kamera DSLR',
                'stok' => '10',
                'harga' => '500000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Tripod Profesional',
                'stok' => '20',
                'harga' => '150000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Lensa Zoom',
                'stok' => '5',
                'harga' => '250000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Lampu Studio',
                'stok' => '8',
                'harga' => '100000',
                'status' => 'tersedia',

            ],
        ]);
    }
}
