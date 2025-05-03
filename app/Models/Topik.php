<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topik extends Model
{
    use HasFactory;
    
    protected $table = 'topik';
    protected $fillable = ['judul', 'tahun'];

    public function layanan()
    {
        return $this->belongsToMany(Layanan::class, 'layanan_topik', 'id', 'layanan_id');
    }

    public function soal()
    {
        return $this->hasMany(Soal::class);
    }

}
