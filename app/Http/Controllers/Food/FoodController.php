<?php

namespace App\Http\Controllers\Food;

use App\Exceptions\InsufficientBalanceException;
use App\Http\Controllers\Controller;
use App\Http\Requests\FoodBuyRequest;
use App\Http\Requests\FoodRequest;
use App\Http\Requests\FoodUpdateRequest;
use App\Http\Resources\FoodPurchaseResource;
use App\Http\Resources\FoodResource;
use App\Http\Resources\UserResource;
use App\Models\Food;
use App\Models\Food_purchase;
use App\Models\UserDog;
use App\Services\FoodService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

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
    public function store(FoodRequest $request): RedirectResponse
    {
        $this->service->create($request);

        session()->flash('success', 'Food created successfully!');

        return redirect()->route('admin.add-food');
    }

    public function index(): View
    {
        $foods = Food::all();
        return view('admin.foods.index', compact('foods'));
    }

    public function edit(Food $food): View
    {
        return view('admin.foods.edit', compact('food'));
    }

    /**
     * @throws Exception
     */
    public function update(FoodUpdateRequest $request, Food $food): RedirectResponse
    {
        $this->service->update($request, $food);
        session()->flash('success', 'Food updated successfully!');
        return redirect()->route('admin.foods.index');
    }

    public function destroy(Food $food): RedirectResponse
    {
        Storage::delete($food->image_url);
        $food->delete();
        session()->flash('success', 'Food deleted successfully!');
        return redirect()->route('admin.foods.index');
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
            $dog = UserDog::where('user_id', $user->id)->first();
            $dog->health_level += 1;
            $dog->hunger_level += 1;
            $dog->save();
            $user->balance -= $food_purchase->food->price;
            $user->save();
        } catch (InsufficientBalanceException $e) {
            return $e->render($request);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        $food_purchaseInfo = new FoodPurchaseResource($food_purchase);

        return (new UserResource($user))->additional(['food' => $food_purchaseInfo]);
    }

}
