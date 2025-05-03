<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    public $timestamps = true;
    protected $fillable = ['id', 'nama'];
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($kategori) {
            $latest = static::orderBy('id', 'desc')->first();
            $number = $latest ? intval(substr($latest->id, 3)) + 1 : 1;
            $kategori->id = 'KTG' . str_pad($number, 3, '0', STR_PAD_LEFT);
        });
    }

    public function layanan()
    {
        return $this->hasMany(Layanan::class, 'kategori_id', 'id');
    }
}
