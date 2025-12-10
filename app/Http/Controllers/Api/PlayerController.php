<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlayerRequest;
use App\Services\PlayerService;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
       protected $service;

    public function __construct(PlayerService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAll());
    }

    public function show($id){
        return response()->json($this->service->show($id));

    }

    public function store(PlayerRequest $request)
    {
        return response()->json($this->service->create($request->validated()), 201);
    }

    public function update(PlayerRequest $request, $id)
    {
        return response()->json($this->service->update($id, $request->validated()));
    }

    public function destroy($id)
    {
        return response()->json($this->service->delete($id));
    }
}
