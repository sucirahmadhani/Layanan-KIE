<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta'; // Nama tabel di database
    protected $fillable = ['nama', 'username', 'password', 'email'];

    protected $hidden = ['password'];
}
