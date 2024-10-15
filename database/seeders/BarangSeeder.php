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
                'nama_barang' => 'Tenda Kapasitas 4/5',
                'stok' => '1',
                'harga' => '40000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Tenda Kapasitas 3/4',
                'stok' => '1',
                'harga' => '35000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Tenda Kapasitas 2',
                'stok' => '2',
                'harga' => '25000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Carrier 50-60L',
                'stok' => '2',
                'harga' => '30000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Daypack 25-35L',
                'stok' => '1',
                'harga' => '15000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Nesting',
                'stok' => '3',
                'harga' => '10000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Kompor',
                'stok' => '2',
                'harga' => '100000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Sleeping Bag',
                'stok' => '3',
                'harga' => '8000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Tracking Pole',
                'stok' => '3',
                'harga' => '8000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Flysheet',
                'stok' => '1',
                'harga' => '10000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Tiang Flysheet',
                'stok' => '1',
                'harga' => '8000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Footprint',
                'stok' => '1',
                'harga' => '8000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Matras',
                'stok' => '5',
                'harga' => '5000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Matras Foil',
                'stok' => '2',
                'harga' => '8000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Headlamp',
                'stok' => '3',
                'harga' => '8000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Lampu Tenda',
                'stok' => '2',
                'harga' => '8000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Senter',
                'stok' => '1',
                'harga' => '5000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Tempat Telur Isi 6',
                'stok' => '2',
                'harga' => '5000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Kursi Lipat',
                'stok' => '4',
                'harga' => '10000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Meja Lipat',
                'stok' => '2',
                'harga' => '15000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Tiker Piknik',
                'stok' => '1',
                'harga' => '5000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Hamnock',
                'stok' => '2',
                'harga' => '8000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Tripod+Remote',
                'stok' => '3',
                'harga' => '10000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Compot Portable',
                'stok' => '3',
                'harga' => '20000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Grillpan',
                'stok' => '3',
                'harga' => '15000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Lensa Apexel',
                'stok' => '1',
                'harga' => '15000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Gas',
                'stok' => '9',
                'harga' => '10000',
                'status' => 'tersedia',

            ],
            [
                'nama_barang' => 'Gas Reffil',
                'stok' => '9',
                'harga' => '8000',
                'status' => 'tersedia',

            ],
        ]);
    }
}
