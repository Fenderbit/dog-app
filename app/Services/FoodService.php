<?php

namespace App\Services;

use App\Exceptions\InsufficientBalanceException;
use App\Http\Requests\FoodBuyRequest;
use App\Http\Requests\FoodRequest;
use App\Http\Requests\FoodUpdateRequest;
use App\Models\Food;
use App\Models\Food_purchase;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            return Food::create([
                'name' => $validatedData['name'],
                'price' => $validatedData['price'],
                'income_price' => $validatedData['income_price'],
                'duration_hours' => $validatedData['duration_hours'],
                'image_url' => $validatedData['image_url']
            ]);
        });
    }

    /**
     * @throws Exception
     */
    public function update(FoodUpdateRequest $request, Food $food)
    {
        $validatedData = $request->validated();
        if(isset($validatedData['image_url'])){
            Storage::delete($food->image_url);
            $profilePicturePath = $this->service->store($request, 'foods');


            $validatedData['image_url'] = $profilePicturePath;
        }


        return DB::transaction(function () use ($validatedData, $food) {
            return $food->update($validatedData);
        });
    }


    /**
     * @throws Exception
     */
    public function createFoodPurchase(FoodBuyRequest $request)
    {
        $food = Food::where('id', $request->food_id)->first();

        if ($food) {
            if ($request->user()->balance < $food->price) {
                throw new InsufficientBalanceException("Insufficient balance");
            }
            return DB::transaction(function () use ($request) {
                return Food_purchase::create([
                    'user_id' => $request->user()->id,
                    'food_id' => $request->food_id,
                    'purchased_at' => Carbon::now('Asia/Aqtobe'),
                ]);
            });
        } else {
            throw new Exception('There is no such food');
        }

    }
}
