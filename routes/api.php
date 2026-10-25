<?php

use App\Http\Controllers\Api\ServiceController;
use Illuminate\Support\Facades\Route;

Route::name('api.')
    ->middleware(['throttle:60,1', 'api.key'])
    ->group(function (): void {
        Route::apiResource('v2/services', ServiceController::class);
    });
