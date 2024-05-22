<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatBotController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ChatBotController::class, 'index'])->name('chatbot.index');
Route::post('/chatbot/ask', [ChatBotController::class, 'ask'])->name('chatbot.ask');
