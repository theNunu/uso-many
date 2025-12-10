<?php

namespace App\Services;

use App\Models\Career;
use App\Models\Player;
use App\Repositories\PlayerRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PlayerService
{
    protected $repo;

    public function __construct(PlayerRepository $repo)
    {
        $this->repo = $repo;
    }

    public function getAll()
    {
        $players = $this->repo->getAll();
        return $players->map(function ($player) {
            return [
                'player_id' => $player->player_id,
                'player_name' => $player->name,
                'age' => $player->age,
                'position' => $player->position,
                // careers mapeadas
                'careers' => $player->careers->map(function ($career) {
                    return [
                        'career_id' => $career->career_id,
                        'team' => $career->team
                    ];
                }),
            ];
        });
    }

    public function show($id)
    {
        $player = Player::with('careers')->where('player_id', $id)->get();

        if (!$player) {
            throw new NotFoundHttpException('No existe el ID del player.');
        }

        return $player->map(function ($p) {
            return [
                'player_id' => $p->player_id,
                'player_name' => $p->name,
                'age' => $p->age,
                'position' => $p->position,
                // careers mapeadas
                'careers' => $p->careers->map(function ($career) {
                    return [
                        'career_id' => $career->career_id,
                        'team' => $career->team
                    ];
                }),
            ];
        });
    }

    public function showByCareer($careerId) //obtener jugador pertenecienete a la carrera asignada
    {
        $career = Career::with('player')->find($careerId);

        if (!$career) {
            throw new NotFoundHttpException('No existe el ID career');
        }

        if (!$career->player) {
            throw new NotFoundHttpException('Este career no tiene player asociado');
        }

        return [
            'career_id' => $career->career_id,
            'team' => $career->team,
            'season' => $career->season,
            'player' => [
                'id' => $career->player->player_id,
                'name' => $career->player->name,
                'age' => $career->player->age,
                'position' => $career->player->position,
            ],
        ];
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
