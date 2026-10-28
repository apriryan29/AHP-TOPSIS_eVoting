<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerbandinganKriteria extends Model
{
    protected $fillable = [
        'kriteria_1_id',
        'kriteria_2_id',
        'nilai',
    ];

    public function kriteria1()
    {
        return $this->belongsTo(ValidasiKandidat::class, 'kriteria_1_id');
    }

    public function kriteria2()
    {
        return $this->belongsTo(ValidasiKandidat::class, 'kriteria_2_id');
    }
}