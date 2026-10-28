<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model
{
    protected $fillable = [
        'nama',
        'nia',
        'asal_komisariat',
        'tahun_dad',
        'visi',
        'misi',
        'foto',
        'status',
    ];

    public function penilaian()
    {
        return $this->hasMany(PenilaianKandidat::class);
    }
    public function voteDetails()
    {
        return $this->hasMany(VoteDetail::class, 'candidate_id');
    }
}