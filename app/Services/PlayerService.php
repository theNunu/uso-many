<?php

namespace App\Services;

use App\Repositories\PlayerRepository;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class PlayerService
{
    protected $repo;

    public function __construct(PlayerRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAll()
    {
        return $this->repo->getAll();
    }

    public function show($id)
    {
        $player = $this->repo->find($id);

        if(!$player){
            throw new  NotFoundResourceException('no existe el id del palyer');
        }

        return $player;

        return $player = [
            'player_name' => $player->name,
            'age' => $player->age,
            'position' => $player->position,
        ];
        // return  $player;
    }


    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    public function update($id, array $data)
    {
        $player = $this->repo->find($id);
        return $this->repo->update($player, $data);
    }

    public function delete($id)
    {
        $player = $this->repo->find($id);
        return $this->repo->delete($player);
    }
}
