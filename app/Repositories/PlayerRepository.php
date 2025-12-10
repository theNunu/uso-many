<?php

namespace App\Repositories;

use App\Models\Player;

class PlayerRepository
{
    public function getAll()
    {
        return Player::with('careers')->get();
    }

    public function find($id)
    {
        return Player::with('careers')->where('player_id', $id)->first();
        


        // return $p;
    }

    public function create(array $data)
    {
        return Player::create($data);
    }

    public function update(Player $player, array $data)
    {
        $player->update($data);
        return $player;
    }

    public function delete(Player $player)
    {
        $player->delete();
    }
}
