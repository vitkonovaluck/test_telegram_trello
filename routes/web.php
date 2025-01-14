<?php

use App\Http\Controllers\TelegramController;
use App\Http\Controllers\TrelloController;
use Illuminate\Support\Facades\Route;


Route::get('/telegram', [TelegramController::class,'index']);
Route::get('/set_trello_webhook', [TrelloController::class,'setwebhook']);
Route::get('/trello', [TrelloController::class,'index']);
