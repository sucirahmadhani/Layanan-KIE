<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $table = 'soal';

    protected $fillable = [
        'topik_id',
        'pertanyaan',
        'opsi_benar',
        'opsi_salah',
    ];

    protected $casts = [
        'opsi_salah' => 'array',
    ];

    public function topik()
    {
        return $this->belongsTo(Topik::class);
    }
}
