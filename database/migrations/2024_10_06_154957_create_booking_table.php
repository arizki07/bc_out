<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booking', function (Blueprint $table) {
            $table->id();
            $table->text('barang_id');
            $table->string('paket')->nullable();
            $table->string('customer')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('alamat')->nullable();
            $table->date('tgl_sewa')->nullable();
            $table->date('tgl_kembali')->nullable();
            $table->string('jaminan_sewa')->nullable();
            $table->string('uang_dp')->nullable();
            $table->string('total_bayar')->nullable();
            $table->enum('status', ['lunas', 'belum', 'pending']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking');
    }
};
