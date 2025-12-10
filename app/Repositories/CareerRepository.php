<?php

namespace App\Repositories;

use App\Models\Career;

class CareerRepository
{
    public function create(array $data)
    {
        return Career::create($data);
    }

    public function update(Career $career, array $data)
    {
        $career->update($data);
        return $career;
    }

    public function delete(Career $career)
    {
        $career->delete();
    }
}
