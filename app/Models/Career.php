<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = [
        'player_id',
        'team',
        'season',
        'matches',
        'goals'
    ];

    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id', 'player_id');
    }
}
