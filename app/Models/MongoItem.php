<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Model as MongoModel;
class MongoItem extends MongoModel
{
    protected $connection = 'mongodb';
    protected $collection = 'items_publicos';

    protected $primaryKey = '_id';
    public $incrementing = false;
    protected $keyType = 'int';


    protected $fillable = [
        '_id',
        'title',
        'description',
        'vigente_desde',
        'vigente_hasta',
        'catalogs'
    ];

    // Los catálogos serán un array
    protected $casts = [
        'catalogs' => 'array'
    ];
}
