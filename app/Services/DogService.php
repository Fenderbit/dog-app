<?php

namespace App\Services;

use App\Http\Requests\DogBuyRequest;
use App\Http\Requests\DogRequest;
use App\Models\Dog;
use App\Models\UserDog;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DogService
{
    private ImageService $service;

    public function __construct(ImageService $service)
    {
        $this->service = $service;
    }

    /**
     * @throws Exception
     */
    public function create(DogRequest $request)
    {
        $validatedData = $request->validated();

        $profilePicturePath = $this->service->store($request, 'dogs');

        $validatedData['image_url'] = $profilePicturePath;

        return DB::transaction(function () use ($validatedData) {
            return Dog::create($validatedData);
        });
    }

    public function createUserDog(DogBuyRequest $request)
    {
        $dog = Dog::where('id', $request->dog_id)->first();

        return DB::transaction(function () use ($dog, $request) {
            return UserDog::create([
                'user_id' => $request->user()->id,
                'dog_id' => $request->dog_id,
                'name' => $dog->name,
                'health_level' => $dog->health_level,
                'hunger_level' => $dog->hunger_level,
                'image_url' => $dog->image_url,
                'price' => $dog->price,
                'last_feeding_time' => $dog->last_feeding_time,
            ]);
        });
    }

}
