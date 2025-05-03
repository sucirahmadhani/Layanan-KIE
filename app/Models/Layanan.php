<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';
    protected $primaryKey = 'layanan_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'layanan_id',
        'narasumber_id',
        'kategori_id',
        'tanggal',
        'tempat',
        'waktu',
        'jumlah_peserta',
        'surat',
        'nama_instansi',
        'jenis_layanan',
        'minggu',
        'bulan',
        'opsi_tanggal',
    ];

    public function narasumber()
    {
        return $this->belongsTo(Narasumber::class, 'narasumber_id', 'narasumber_id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id', 'id');
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'layanan_id', 'layanan_id');
    }

    public function pengguna()
    {
        return $this->belongsToMany(Pengguna::class, 'layanan_pengguna', 'layanan_id', 'pengguna_id')
                    ->withPivot('tes_id');
    }

    public function topik()
    {
        return $this->belongsToMany(Topik::class, 'layanan_topik', 'layanan_id', 'topik_id');
    }

    public function realisasi()
    {
        return $this->hasOne(Realisasi::class, 'layanan_id', 'layanan_id');
    }

    public static function generateLayananId()
    {
        $lastRecord = self::orderBy('layanan_id', 'desc')->first();

        if (!$lastRecord) {
            return 'KIE00001';
        }

        $lastId = intval(substr($lastRecord->layanan_id,3));
        $newId = 'KIE' . str_pad($lastId + 1, 5, '0', STR_PAD_LEFT);
        return $newId;
    }
}
