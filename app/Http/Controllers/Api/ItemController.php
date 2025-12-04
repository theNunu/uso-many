<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use App\Services\ItemService;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    protected $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function index()
    {
        return response()->json($this->itemService->getAll());
    }

    public function store(StoreItemRequest $request)
    {
        $item = $this->itemService->store($request->validated());
        return response()->json($item, 201);
    }

    public function show(Item $item)
    {
        return response()->json($item->load('catalogs'));
    }

    public function update(UpdateItemRequest $request, Item $item)
    {
        $item = $this->itemService->update($item, $request->validated());
        return response()->json($item);
    }

    public function destroy(Item $item)
    {
        $this->itemService->delete($item);
        return response()->json(['message' => 'Deleted']);
    }

    // GET /items/valid
    public function getValidItems()
    {
        $items = $this->itemService->getValidItems();

        return response()->json([
            'success' => true,
            'data'    => $items
        ], 200);
    }

public function expiredItems()
{
    return response()->json([
        'success' => true,
        'data' => $this->itemService->getExpiredItems()
    ]);
}

public function orderedByVigency()
{
    return response()->json([
        'success' => true,
        'data' => $this->itemService->getItemsOrderedByVigency()
    ]);
}
}
