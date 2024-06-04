<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Dog\DogController;
use App\Http\Controllers\Food\FoodController;
use App\Http\Controllers\Shop\ShopController;
use App\Http\Controllers\User\UserController;
use App\Http\Middleware\CheckTimeMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum', CheckTimeMiddleware::class])->group(function () {

    Route::patch('/user', [UserController::class, 'updateForApi']);
    Route::get('/user', [UserController::class, 'showForApi']);

    Route::post('dog/buy', [DogController::class, 'buy']);

    Route::post('food/buy', [FoodController::class, 'buy']);

    Route::get('/shop', [ShopController::class, 'index']);

    /*TODO обновление, удаление, получение всех и одной собаки
    TODO купить еду добавление в фуд пурчэйз
    TODO создание, обновление, удаление, получение всех и одной еды
    TODO CRUD пользователя
    */
});
