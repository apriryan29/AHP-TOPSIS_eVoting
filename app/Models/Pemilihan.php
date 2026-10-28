<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pemilihan extends Model
{
    protected $fillable = [
        'nama_pemilihan',
        'deskripsi',
        'maksimal_pilihan',
        'mulai',
        'selesai',
        'is_active',
    ];

    protected $casts = [
        'mulai' => 'datetime',
        'selesai' => 'datetime',
        'is_active' => 'boolean',
    ];
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
    
    public function kandidat(): HasMany
    {
        return $this->hasMany(Kandidat::class);
    }

    public function getIsActiveAttribute(): bool
    {
        if (! $this->mulai || ! $this->selesai) {
            return false;
        }

        return Carbon::now()->between($this->mulai, $this->selesai);
    }

    public function ketuaUmum()
    {
        return $this->belongsTo(Kandidat::class, 'ketua_umum_id');
    }
}