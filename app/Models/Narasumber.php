<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Narasumber extends Model
{
    protected $table = 'narasumber';
    protected $primaryKey = 'narasumber_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'narasumber_id',
        'instansi',
        'nama_narasumber',
        'jabatan',
        'email',
        'no_hp',
        'keahlian'
    ];

    public function layanan()
    {
        return $this->hasMany(Layanan::class, 'narasumber_id', 'narasumber_id');
    }

    public static function generateNarasumberId()
    {
        $lastRecord = self::orderBy('narasumber_id', 'desc') -> first();

        if (!$lastRecord) {
            return 'NRS0001';
        }

        $lastId = intval (substr($lastRecord->narasumber_id, 3));
        $newId = 'NRS' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);
        return $newId;
    }
}
