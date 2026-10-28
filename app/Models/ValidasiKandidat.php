<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ValidasiKandidat extends Model
{
    protected $fillable = [
        'kriteria',
        'nilai',
        'atribut',
        'kode',
    
    ];

    public function penilaian()
    {
        return $this->hasMany(PenilaianKandidat::class);
    }
}
