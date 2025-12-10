<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlayerRequest;
use App\Services\PlayerService;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function show($id)
    {
        try {
            $player = $this->service->show($id);

            return response()->json([
                'success' => true,
                'data' => $player
            ], 200);
        } catch (NotFoundHttpException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function showByCareer($careerId)
    {
        try {
            $data = $this->service->showByCareer($careerId);

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (NotFoundHttpException $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function careersWithPlayers()
    {
        // dd('ded');
        $data = $this->service->getAllCareersWithPlayers();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
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
