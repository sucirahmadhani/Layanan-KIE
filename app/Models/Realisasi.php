<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Realisasi extends Model
{
    use HasFactory;

    protected $table = 'realisasi';

    protected $fillable = [
        'layanan_id',
        'topik_realisasi',
        'jumlah_peserta_hadir',
        'tempat_realisasi',
        'tanggal_realisasi',
        'waktu_realisasi',
        'narasumber',
        'foto',
        'laporan',
        'catatan',
    ];


    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }

}
