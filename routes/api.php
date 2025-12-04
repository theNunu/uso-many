<?php

use App\Http\Controllers\Api\ItemController;
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
    Route::put('/update/{item}', [ItemController::class, 'update']);
    Route::delete('/{item}', [ItemController::class, 'destroy']);
});
