<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\Kategori;


class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        DB::table('pengguna')->insert([
            'nama' => 'Balai Besar POM di Padang',
            'username' => 'bbpompadang',
            'password' => Hash::make('bbpompadang'),
            'email' => 'sucirahmadhani0508@gmail.com',
            'role' => 'admin'
        ]);

        $kategori = [
            'PAUD/TK',
            'SD',
            'SMP',
            'SMA',
            'Mahasiswa',
            'Umum',
            'Pemerintah'
        ];

        foreach ($kategori as $nama) {
            kategori::create(['nama' => $nama]);
        }
    }
}
