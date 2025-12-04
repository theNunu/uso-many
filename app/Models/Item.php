<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $primaryKey = 'item_id';

    protected $fillable = [
        'title',
        'description',

        'vigente_desde',
        'vigente_hasta',
    ];

    public function catalogs()
    {
        return $this->belongsToMany(Catalog::class, 'item_catalog', 'item_id', 'catalog_id');
    }
}
