<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GutsController;

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); */


Route::post('/guts', [GutsController::class, 'send']);
Route::get('/slack/oauth/callback', [GutsController::class, 'auth']);