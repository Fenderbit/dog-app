<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Resources\DogCollection;
use App\Http\Resources\FoodCollection;
use App\Models\Dog;
use App\Models\Food;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(): JsonResponse
    {
        $dogs = new DogCollection(Dog::all());
        $foods = new FoodCollection(Food::all());

        return response()->json([
            'data' => [
                'dogs' => $dogs,
                'foods' => $foods,
            ],
        ]);
    }
}
