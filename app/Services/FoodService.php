<?php

namespace App\Services;

use App\Exceptions\InsufficientBalanceException;
use App\Http\Requests\FoodBuyRequest;
use App\Http\Requests\FoodRequest;
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
            return Food::create($validatedData);
        });
    }

    /**
     * @throws Exception
     */
    public function update(FoodRequest $request, Food $food)
    {
        $validatedData = $request->validated();

        $profilePicturePath = $this->service->store($request, 'foods');
        Storage::delete($food->image_url);

        $validatedData['image_url'] = $profilePicturePath;

        return DB::transaction(function () use ($request, $food) {
            return $food->update($request->all());
        });
    }


    /**
     * @throws Exception
     */
    public function createFoodPurchase(FoodBuyRequest $request)
    {
        $food = Food::where('id', $request->food_id)->first();

        if($food){
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
        }else{
            throw new Exception('There is no such food');
        }

    }
}
