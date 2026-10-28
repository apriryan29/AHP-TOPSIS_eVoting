<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoteDetail extends Model
{
    protected $fillable = [
        'vote_id',
        'candidate_id',
    ];

    public function vote()
    {
        return $this->belongsTo(Vote::class);
    }

    public function kandidat()
    {
        return $this->belongsTo(Kandidat::class, 'candidate_id');
    }
}