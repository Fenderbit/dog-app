<?php

namespace App\Services;

use App\Http\Requests\FoodBuyRequest;
use App\Http\Requests\FoodRequest;
use App\Models\Food;
use App\Models\Food_purchase;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class FoodService
{
    private ImageService $service;

    public function __construct(ImageService $service)
    {
        $this->service = $service;
    }

    /**
     * @throws Exception
     */
    public function create(FoodRequest $request)
    {
        $validatedData = $request->validated();

        $profilePicturePath = $this->service->store($request, 'foods');

        $validatedData['image_url'] = $profilePicturePath;
        $validatedData['income_price'] = 1 + ($validatedData['income_price'] / 100);

        return DB::transaction(function () use ($validatedData) {
            return Food::create($validatedData);
        });
    }

    /**
     * @throws Exception
     */
    public function createFoodPurchase(FoodBuyRequest $request)
    {
        $food = Food::where('id', $request->food_id)->first();

        if ($request->user()->balance < $food->price) {
            throw new Exception("Insufficient balance", 400);
        }
        return DB::transaction(function () use ($request) {
            return Food_purchase::create([
                'user_id' => $request->user()->id,
                'food_id' => $request->food_id,
                'purchased_at' => Carbon::now(),
            ]);
        });
    }
}
