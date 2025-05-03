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
        Schema::create('narasumber', function (Blueprint $table) {
            $table->string('narasumber_id', 10)->primary();
            $table->string('instansi', 50);
            $table->string('nama_narasumber', 100);
            $table->string('jabatan', 10);
            $table->string('email', 50);
            $table->string('no_hp', 16);
            $table->string('keahlian', 50);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('narasumber');
    }
};
