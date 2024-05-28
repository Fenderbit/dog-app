<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Dog\DogController;
use App\Http\Controllers\Food\FoodController;
use App\Http\Controllers\User\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login'])->name('login.submit');

        Route::middleware([AdminMiddleware::class])->group(function () {

            Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('dashboard');

            Route::get('logout', [AdminAuthController::class, 'logout'])->name('logout');

            // User Management
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
            Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
            Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
            Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

            // Dog Management for Users
            Route::get('/users/{user}/dogs/{dog}/edit', [UserController::class, 'editDog'])->name('editDog');
            Route::post('/users/{user}/dogs', [UserController::class, 'addDog'])->name('users.addDog');
            Route::put('/users/{user}/dogs/{dog}', [UserController::class, 'updateDog'])->name('users.updateDog');
            Route::delete('/users/{user}/dogs/{dog}', [UserController::class, 'deleteDog'])->name('users.deleteDog');

            // Food Purchases Management for Users
            Route::get('/users/{user}/foods/create', [UserController::class, 'createFood'])->name('users.createFood');
            Route::post('/users/{user}/foods', [UserController::class, 'addFood'])->name('users.addFood');
            Route::get('/users/{user}/foods/{food}/edit', [UserController::class, 'editFood'])->name('users.editFood');
            Route::put('/users/{user}/foods/{food}', [UserController::class, 'updateFood'])->name('users.updateFood');
            Route::delete('/users/{user}/foods/{food}', [UserController::class, 'deleteFood'])->name('users.deleteFood');

            // Dog Management
            Route::get('/dogs', [DogController::class, 'index'])->name('dogs.index');
            Route::post('/dogs', [DogController::class, 'store'])->name('dogs.store');
            Route::get('/dogs/{dog}/edit', [DogController::class, 'edit'])->name('dogs.edit');
            Route::put('/dogs/{dog}', [DogController::class, 'update'])->name('dogs.update');
            Route::delete('/dogs/{dog}', [DogController::class, 'destroy'])->name('dogs.destroy');

            Route::get('/add-dog', function () {
                return view('admin.add_dog');
            })->name('add-dog');

            // Food Management
            Route::get('/foods', [FoodController::class, 'index'])->name('foods.index');
            Route::get('/foods/{food}/edit', [FoodController::class, 'edit'])->name('foods.edit');
            Route::put('/foods/{food}', [FoodController::class, 'update'])->name('foods.update');
            Route::delete('/foods/{food}', [FoodController::class, 'destroy'])->name('foods.destroy');

            Route::post('/foods', [FoodController::class, 'store'])->name('foods.store');
            Route::get('/add-food', function () {
                return view('admin.add_food');
            })->name('add-food');
        });
});
