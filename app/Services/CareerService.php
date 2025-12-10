<?php

namespace App\Services;

use App\Repositories\CareerRepository;
use App\Models\Career;

class CareerService
{
    protected $repo;

    public function __construct(CareerRepository $repo)
    {
        $this->repo = $repo;
    }

    public function create(array $data)
    {
        return $this->repo->create($data);
    }

    public function update($id, array $data)
    {
        $career = Career::findOrFail($id);
        return $this->repo->update($career, $data);
    }

    public function delete($id)
    {
        $career = Career::findOrFail($id);
        return $this->repo->delete($career);
    }
}
