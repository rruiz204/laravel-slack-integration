<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GutsController;

Route::post('/guts/send', [GutsController::class, 'send']);
/* Route::get('/slack/oauth/callback', [GutsController::class, 'auth']); */