<?php

namespace App\Http\Controllers\Food;

use App\Http\Controllers\Controller;
use App\Http\Requests\FoodBuyRequest;
use App\Http\Requests\FoodRequest;
use App\Http\Resources\FoodPurchaseResource;
use App\Http\Resources\FoodResource;
use App\Http\Resources\UserResource;
use App\Models\Food_purchase;
use App\Services\FoodService;
use Exception;
use Illuminate\Http\JsonResponse;

class FoodController extends Controller
{
    private FoodService $service;

    public function __construct(FoodService $service)
    {
        $this->service = $service;
    }

    /**
     * @throws Exception
     */
    public function store(FoodRequest $request): FoodResource
    {
        $food = $this->service->create($request);

        return new FoodResource($food);
    }

    public function buy(FoodBuyRequest $request): UserResource|JsonResponse
    {
        $user = $request->user();
        $food = Food_purchase::where('user_id', $user->id)
            ->where('food_id', $request->food_id)
            ->where('is_consumed', false)
            ->first();

        if (!is_null($food)) {
            return response()->json(['error' => 'You already bought this food.'], 400);
        }
        try {
            $food_purchase = $this->service->createFoodPurchase($request);
            $user->balance -= $food_purchase->food->price;
            $user->save();
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        $food_purchaseInfo = new FoodPurchaseResource($food_purchase);

        return (new UserResource($user))->additional(['food' => $food_purchaseInfo]);
    }

}
