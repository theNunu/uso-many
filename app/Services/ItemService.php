<?php

namespace App\Services;

use App\Models\Catalog;
use App\Repositories\ItemRepository;
use App\Models\Item;
use App\Models\MongoItem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Artisan;

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
        // return $this->itemRepository->create($data);

        // 1. Crear en SQLite
        $item = Item::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'vigente_desde' => $data['vigente_desde'],
            'vigente_hasta' => $data['vigente_hasta']
        ]);

        // 2. Relacionar los catálogos
        $item->catalogs()->sync($data['catalog_ids']);

        // 3. Obtener los catálogos en formato simple
        $catalogs = $item->catalogs()->get(['catalogs.catalog_id', 'catalogs.name'])->toArray();
        

        // 4. Guardar copia en Mongo
        MongoItem::create([
            '_id' => $item->item_id, // conservar ID entero de SQLite
            'title' => $item->title,
            'description' => $item->description,
            'vigente_desde' => $item->vigente_desde,
            'vigente_hasta' => $item->vigente_hasta,
            'catalogs' => $catalogs
        ]);

        return $item;
    }

    public function update(Item $item, $data)
    {
        return $this->itemRepository->update($item, $data);
    }

    public function delete(Item $item)
    {
        return $this->itemRepository->delete($item);
    }


    public function getItemByCatalog($catalogId)
    {
        // return Catalog::where('catalog_id', $catalogId)->get();
        $items = Item::whereHas('catalogs', function ($query) use ($catalogId) {
            $query->where('item_catalog.catalog_id', $catalogId);
        })->get();

        return $items->map(function ($item) {
            return [
                'item_id'     => $item->item_id,
                'title'       => $item->title,
                'description' => $item->description,
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

    public function syncCatalogs($command_name)
    {
        try {

            $allCommands = Artisan::all(); 
            if (!array_key_exists($command_name, $allCommands)) {
                return [
                    'success' => false,
                    'message' => "El comando ingresado no existe",
                ];
            }

            // if(!$command_name){
            //     return "no existeeee";
            // }
            //sync:catalog-catalogDetails
            $exitCode = Artisan::call($command_name);
            // $output = Artisan::output();

            return $exitCode;

            // if ($exitCode === 0) {
            //     return [
            //         'success' => true,
            //         'message' => 'Migración hecha correctamente',
            //     // 'output'  => $output,
            //     ];
            // }

            // return [
            //     'success' => false,
            //     'message' => 'La migración no se realizó',
            // // 'output'  => $output,
            // ];

        } catch (\Exception $e) {

            // \Log::error("Error ejecutando sync:catalog-catalogDetails → " . $e->getMessage());

            return [
                'success' => false,
                'message' => 'La migración no se realizó (excepción)',
                'error'   => $e->getMessage(),
            ];
        }
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
