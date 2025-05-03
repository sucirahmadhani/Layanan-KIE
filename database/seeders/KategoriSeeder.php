<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
