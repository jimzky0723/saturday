<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boxscore extends Model
{
    protected $table = 'boxscore';
    protected $fillable = [
        'game_id',
        'team',
        'player_id',
        'fg2m',
        'fg2a',
        'fg3m',
        'fg3a',
        'ftm',
        'fta',
        'oreb',
        'dreb',
        'ast',
        'stl',
        'blk',
        'turnover',
        'pf',
        'pts'
    ];
}
