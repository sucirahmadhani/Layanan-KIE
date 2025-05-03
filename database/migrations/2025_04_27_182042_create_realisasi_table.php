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
        Schema::create('realisasi', function (Blueprint $table) {
            $table->id();
            $table->string('layanan_id');
            $table->integer('jumlah_peserta_hadir')->nullable();
            $table->string('tempat_realisasi')->nullable();
            $table->date('tanggal_realisasi')->nullable();
            $table->string('waktu_realisasi')->nullable();
            $table->string('narasumber')->nullable();
            $table->string('foto')->nullable(); // nama file foto
            $table->string('laporan')->nullable(); // nama file laporan
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('realisasi');
    }
};
