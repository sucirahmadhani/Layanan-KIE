<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomVerifyEmail;

class Pengguna extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $table = 'pengguna';

    protected $fillable = [
        'nama',
        'username',
        'email',
        'phone_number',
        'password',
        'role',
        'profile_updated',
        'expired_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'expired_at' => 'datetime',
        'profile_updated' => 'boolean',
    ];

    public function layanan()
    {
        return $this->belongsToMany(Layanan::class, 'layanan_pengguna', 'pengguna_id', 'layanan_id');
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }
}
