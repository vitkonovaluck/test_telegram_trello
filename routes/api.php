<?php

use App\Http\Controllers\TelegramController;

use App\Http\Controllers\TrelloController;
use Illuminate\Support\Facades\Route;


Route::post('/telegram_webhook',[TelegramController::class,'webhook']);
Route::get('/trello_webhook',function (){
    return response()->json(['success' => 'success', 200]);
});
Route::post('/trello_webhook',[TrelloController::class,'webhook']);

