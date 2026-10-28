<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Vote extends Authenticatable
{
    protected $fillable = [
        'nama',
        'email',
        'password',
        'password_awal',
        'komisariat',
        'token',
        'status_verifikasi',
        'status_memilih',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'status_verifikasi' => 'boolean',
            'status_memilih' => 'boolean',
        ];
    }

    public function details()
    {
        return $this->hasMany(VoteDetail::class);
    }
}