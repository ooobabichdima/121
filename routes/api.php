<?php

use App\Http\Controllers\Api\CartApiController;
use App\Http\Controllers\Api\NovaPoshtaController;
use Illuminate\Support\Facades\Route;

Route::prefix('cart')->group(function () {
    Route::post('add', [CartApiController::class, 'add']);
    Route::post('update', [CartApiController::class, 'update']);
    Route::post('remove', [CartApiController::class, 'remove']);
    Route::get('/', [CartApiController::class, 'show']);
});

Route::get('/nova-poshta/cities', [NovaPoshtaController::class, 'cities']);
Route::get('/nova-poshta/warehouses', [NovaPoshtaController::class, 'warehouses']);
