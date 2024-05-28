<?php

namespace App\Http\Resources;

use App\Models\Food_purchase;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FoodCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->map(function ($food) use ($request) {
            $isConsumed = is_null(Food_purchase::where('user_id', $request->user()->id)
                ->where('food_id', $food->id)
                ->where('is_consumed', false)
                ->first());

            return [
                'id' => $food->id,
                'name' => $food->name,
                'price' => $food->price,
                'income_price' => $food->income_price,
                'duration_hours' => $food->duration_hours,
                'image_url' => $food->image_url,
                'is_consumed' => $isConsumed,
            ];
        })->toArray();
    }
}
