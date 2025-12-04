<?php

namespace App\Services;

use App\Repositories\ItemRepository;
use App\Models\Item;
use Carbon\Carbon;

class ItemService
{
    protected $itemRepository;

    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    public function getAll()
    {
        // return $this->itemRepository->getAll();
        $items = $this->itemRepository->getAll(); // viene con los catalogs completos

        return $items->map(function ($item) {
            return [
                'item_id'     => $item->item_id,
                'title'       => $item->title,
                'description' => $item->description,
                // 'created_at'  => $item->created_at,
                // 'updated_at'  => $item->updated_at,

                // filtramos lo que queremos del catálogo
                'catalogs'    => $item->catalogs->map(function ($cat) {
                    return [
                        'catalog_id' => $cat->catalog_id,
                        'name'       => $cat->name,
                    ];
                }),
            ];
        });
    }

    public function store($data)
    {
        // dd($data);
        return $this->itemRepository->create($data);
    }

    public function update(Item $item, $data)
    {
        return $this->itemRepository->update($item, $data);
    }

    public function delete(Item $item)
    {
        return $this->itemRepository->delete($item);
    }

    public function getValidItems() //estan en el tiempo vigente
    {
        $items = $this->itemRepository->getValidItems();

        // Aquí aplicamos el map para dejar el JSON limpio
        return $items->map(function ($item) {
            return [
                'item_id'     => $item->item_id,
                'title'       => $item->title,
                'description' => $item->description,
                'vigente_desde'    => $item->vigente_desde,
                'vigente_hasta'      => $item->vigente_hasta,
                'status'      => $item->status,
                'catalogs'    => $item->catalogs->map(function ($cat) {
                    return [
                        'catalog_id' => $cat->catalog_id,
                        'name'       => $cat->name,
                    ];
                }),
            ];
        });
    }
    //*++++++++++++++++++++++  1. Obtener primero los vigentes y luego los no vigentes (ordenados)
    public function getItemsOrderedByVigency()
    {
        return $this->itemRepository->getItemsOrderedByVigency();
    }



    public function getExpiredItems()
    {
        return $this->itemRepository->getExpiredItems();
        // $today = Carbon::today()->toDateString();

        // return Item::where('end', '<', $today)
        //     ->with(['catalogs:catalog_id,name'])
        //     ->get();
    }
}
