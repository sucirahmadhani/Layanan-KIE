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
        Schema::create('layanan_pengguna', function (Blueprint $table) {
            $table->unsignedBigInteger('pengguna_id');
            $table->string('layanan_id', 10);
            $table->unsignedBigInteger('tes_id')->nullable();
            $table->primary(['pengguna_id', 'layanan_id']);
      ;

            $table->foreign('layanan_id')->references('layanan_id')->on('layanan')->onDelete('cascade');
            $table->foreign('pengguna_id')->references('id')->on('pengguna')->onDelete('cascade');
            $table->foreign('tes_id')->references('id')->on('tes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_pengguna');
    }
};
