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
            $table->unsignedBigInteger('barang_id');
            $table->string('customer');
            $table->string('no_hp');
            $table->string('alamat');
            $table->date('tgl_sewa');
            $table->date('tgl_kembali');
            $table->string('jaminan_sewa');
            $table->string('uang_dp')->nullable();
            $table->string('total_bayar')->nullable();
            $table->enum('status', ['lunas', 'belum']);
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
