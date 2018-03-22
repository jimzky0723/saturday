<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Games extends Model
{
    protected $table = 'games';
    protected $fillable = [
        'home_team',
        'away_team',
        'date_match',
        'home_score',
        'away_score',
        'winner_id',
        'winner_score',
        'losser_id',
        'losser_score'
    ];
}
