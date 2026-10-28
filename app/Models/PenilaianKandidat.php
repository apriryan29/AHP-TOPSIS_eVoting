<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianKandidat extends Model
{

    protected $fillable = [
        'kandidat_id',
        'validasi_kandidat_id',
        'nilai',
    ];
    public function kandidat()
    {
        return $this->belongsTo(Kandidat::class);
    }

    public function validasiKriteria()
    {
        return $this->belongsTo(ValidasiKandidat::class);
    }
}
