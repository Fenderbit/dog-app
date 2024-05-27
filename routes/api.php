<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dog\DogController;
use App\Http\Controllers\Food\FoodController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('/dog', [DogController::class, 'store']);
    Route::post('/dog/buy', [DogController::class, 'buy']);
    Route::post('/food', [FoodController::class, 'store']);
    /*TODO обновление, удаление, получение всех и одной собаки
    TODO купить еду добавление в фуд пурчэйз
    TODO создание, обновление, удаление, получение всех и одной еды
    TODO CRUD пользователя
    */
});
