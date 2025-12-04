<?php

namespace App\Repositories;

use App\Models\Item;
use Carbon\Carbon;

class ItemRepository
{
    public function getAll()
    {
        return Item::with('catalogs')->get();
    }

    public function find($id)
    {
        return Item::with('catalogs')->first($id);
    }

    public function create(array $data)
    {
        $item = Item::create([
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,

            'vigente_desde' => $data['vigente_desde'] ?? null,
            'vigente_hasta' => $data['vigente_hasta'] ?? null,
        ]);

        $item->catalogs()->sync($data['catalog_ids']);
        return $item->load('catalogs');
    }

    public function update(Item $item, array $data)
    {
        // $item->update($data);
        $item->update([
            'title'       => $data['title']        ?? $item->title,
            'description' => $data['description']  ?? $item->description,

            'vigente_desde' => $data['vigente_desde'] ?? $item->vigente_desde,
            'vigente_hasta' => $data['vigente_hasta'] ?? $item->vigente_hasta,
        ]);
        if (isset($data['catalog_ids'])) {
            $item->catalogs()->sync($data['catalog_ids']);
        }
        return  $item->load('catalogs');
    }

    public function delete(Item $item)
    {
        return $item->delete();
    }

    public function getValidItems()
    {
        $today = Carbon::today()->toDateString();

        return Item::where('vigente_desde', '<=', $today)
            ->where('vigente_hasta', '>=', $today)
            ->with(['catalogs:catalog_id,name'])
            ->get();
    }

    // Solo NO vigentes
    public function getExpiredItems()
    {
        $today = Carbon::today()->toDateString();

        return Item::where('vigente_hasta', '<', $today)
            ->with(['catalogs:catalog_id,name'])
            ->get();
    }

    // Mix: primero vigentes y luego los no vigentes
    public function getItemsOrderedByVigency()
    {
        $today = Carbon::today()->toDateString();

        return Item::select('*')
            ->with(['catalogs:catalog_id,name'])
            ->orderByRaw("CASE WHEN vigente_desde <= '$today' AND vigente_hasta >= '$today' THEN 0 ELSE 1 END")
            ->orderBy('vigente_desde', 'asc')
            ->get();
    }
}
