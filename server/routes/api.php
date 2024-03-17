<?php

use App\Http\Controllers\GameApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [AuthController::class, "register"]);
Route::post('login', [AuthController::class, "login"]);

Route::middleware('auth:api')->group(function () {
    Route::post('/games', [GameApiController::class, 'createGame']);
    Route::delete('/games/{id}', [GameApiController::class, 'deleteGame']);
    Route::put('/games/{id}', [GameApiController::class, 'updateGame']);
});

Route::get("/games", [GameApiController::class, "all"]);
Route::get('/games/{id}', [GameApiController::class, 'getGameById']);
Route::get('/tags', [GameApiController::class, 'getTags']);

Route::get("/languages", [LanguageController::class, "getLanguage"]);