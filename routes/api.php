<?php

use App\Http\Controllers\Api\CareerController;
use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\PlayerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('items')->group(function () {
    Route::get('/', [ItemController::class, 'index']);
    Route::get('/valid', [ItemController::class, 'getValidItems']);

    // Solo ítems no vigentes
    Route::get('/expired', [ItemController::class, 'expiredItems']);

    // Primero vigentes / luego no vigentes
    Route::get('/ordered', [ItemController::class, 'orderedByVigency']);

    Route::post('/create', [ItemController::class, 'store']);
    Route::get('/{item}', [ItemController::class, 'show']);
    Route::get('/catalog/{catalogId}', [ItemController::class, 'getItemByCatalog']);
    Route::put('/update/{item}', [ItemController::class, 'update']);
    Route::delete('/{item}', [ItemController::class, 'destroy']);
});

Route::prefix('comandos')->group(function () {
    Route::post('{command_name}', [ItemController::class, 'probar']);
});



Route::prefix('players')->group(function () {
    Route::get('', [PlayerController::class, 'index']);
    Route::get('{id}', [PlayerController::class, 'show']);
    Route::post('', [PlayerController::class, 'store']);
    Route::put('{id}', [PlayerController::class, 'update']);
    Route::delete('{id}', [PlayerController::class, 'destroy']);
});

Route::prefix('careers')->group(function () {
    Route::post('', [CareerController::class, 'store']);
    Route::put('{id}', [CareerController::class, 'update']);
    Route::delete('{id}', [CareerController::class, 'destroy']);
});
