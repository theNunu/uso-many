<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerRequest;
use App\Services\CareerService;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    protected $service;

    public function __construct(CareerService $service)
    {
        $this->service = $service;
    }

    public function store(CareerRequest $request)
    {
        return response()->json($this->service->create($request->validated()), 201);
    }

    public function update(CareerRequest $request, $id)
    {
        return response()->json($this->service->update($id, $request->validated()));
    }

    public function destroy($id)
    {
        return response()->json($this->service->delete($id));
    }
}
