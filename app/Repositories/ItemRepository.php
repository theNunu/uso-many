<?php

namespace App\Repositories;

use App\Models\Item;

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
        ]);

        $item->catalogs()->sync($data['catalog_ids']);
        return $item;
    }

    public function update(Item $item, array $data)
    {
        // $item->update($data);
        $item->update([
            'title'       => $data['title']        ?? $item->title,
            'description' => $data['description']  ?? $item->description,
        ]);
        if (isset($data['catalog_ids'])) {
            $item->catalogs()->sync($data['catalog_ids']);
        }
        return $item;
    }

    public function delete(Item $item)
    {
        return $item->delete();
    }
}
