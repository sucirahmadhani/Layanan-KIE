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
        Schema::create('layanan', function (Blueprint $table) {
            $table->string('layanan_id', 15)->primary();
            $table->string('narasumber_id', 10)->nullable();
            $table->string('kategori_id', 10);
            $table->date('tanggal')->nullable();
            $table->string('tempat', 100);
            $table->string('waktu', 10);
            $table->integer('jumlah_peserta');
            $table->string('surat', 255);
            $table->string('nama_instansi', 255);
            $table->string('jenis_layanan', 255);
            $table->string('minggu', 10);
            $table->string('bulan', 100);
            $table->date('opsi_tanggal')->nullable();
            $table->timestamps();


            $table->foreign('narasumber_id')->references('narasumber_id')->on('narasumber')->onDelete('cascade');
            $table->foreign('kategori_id')->references('id')->on('kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan');
    }
};
