<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $primaryKey = 'player_id';

    protected $fillable = [
        'name',
        'age',
        'position',
    ];

    public function careers()
    {
        return $this->hasMany(Career::class, 'player_id', 'player_id');
    }
}
