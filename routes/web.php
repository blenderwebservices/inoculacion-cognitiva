<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'api'], function () {
    Route::post('/login', [ApiController::class, 'login']);
    Route::post('/logout', [ApiController::class, 'logout']);
    Route::get('/user', [ApiController::class, 'user']);
    Route::get('/bots', [ApiController::class, 'bots']);
    Route::post('/bots', [ApiController::class, 'createBot']);
    Route::post('/bots/reset', [ApiController::class, 'resetBots']);
    Route::post('/chat', [ApiController::class, 'chat']);
});
