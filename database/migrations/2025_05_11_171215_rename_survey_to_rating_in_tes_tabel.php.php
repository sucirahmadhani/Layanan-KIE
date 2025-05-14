<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
         DB::table('tes')
            ->whereNotNull('survey')
            ->whereRaw("survey !~ '^[0-9]+$'") 
            ->update(['survey' => '0']);


        Schema::table('tes', function (Blueprint $table) {
            DB::statement('ALTER TABLE tes RENAME COLUMN survey TO rating');
            DB::statement('ALTER TABLE tes ALTER COLUMN rating TYPE integer USING rating::integer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tes', function (Blueprint $table) {
            DB::statement('ALTER TABLE tes RENAME COLUMN rating TO survey');
            DB::statement('ALTER TABLE tes ALTER COLUMN survey TYPE text');
        });
    }
};
