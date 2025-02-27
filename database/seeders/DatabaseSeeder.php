<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        DB::table('peserta')->insert([
            'nama' => 'Balai Besar POM di Padang',
            'username' => 'bbpompadang',
            'password' => Hash::make('bbpompadang'),
            'email' => 'sucirahmadhani0508@gmail.com',
        ]);
    }
}
