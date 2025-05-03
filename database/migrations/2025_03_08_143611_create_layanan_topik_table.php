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
        Schema::create('layanan_topik', function (Blueprint $table) {
            $table->string('layanan_id', 10);
            $table->unsignedBigInteger('topik_id');
            $table->timestamps();

            $table->primary(['layanan_id', 'topik_id']);

            $table->foreign('layanan_id')->references('layanan_id')->on('layanan')->onDelete('cascade');
            $table->foreign('topik_id')->references('id')->on('topik')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_topik');
    }
};
