<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Models\UserDog;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DogCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $purchasedDogIds = UserDog::where('user_id', $request->user()->id)->pluck('dog_id')->toArray();

        return $this->collection->map(function ($dog) use ($purchasedDogIds) {
            return [
                'id' => $dog->id,
                'name' => $dog->name,
                'health_level' => $dog->health_level,
                'hunger_level' => $dog->hunger_level,
                'image_url' => $dog->image_url,
                'price' => $dog->price,
                'is_purchased' => in_array($dog->id, $purchasedDogIds),
            ];
        })->toArray();
    }
}
