<?php

namespace App\Services;

use App\Exceptions\InsufficientBalanceException;
use App\Http\Requests\DogBuyRequest;
use App\Http\Requests\DogRequest;
use App\Http\Requests\DogUpdateRequest;
use App\Models\Dog;
use App\Models\UserDog;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            return Dog::create([
                'name' => $validatedData['name'],
                'health_level' => 0,
                'hunger_level' => 0,
                'image_url' => $validatedData['image_url'],
                'price' => $validatedData['price'],
            ]);
        });
    }

    /**
     * @throws Exception
     */
    public function update(DogUpdateRequest $request, Dog $dog)
    {
        $validatedData = $request->validated();

        if(isset($validatedData['image_url'])){
            Storage::delete($dog->image_url);
            $profilePicturePath = $this->service->store($request, 'dogs');

            $validatedData['image_url'] = $profilePicturePath;
        }


        return DB::transaction(function () use ($validatedData, $dog) {
            return $dog->update($validatedData);
        });
    }

    /**
     * @throws Exception
     */
    public function createUserDog(DogBuyRequest $request)
    {
        $dog = Dog::where('id', $request->dog_id)->first();
        if($dog){
            if ($request->user()->balance < $dog->price) {
                throw new InsufficientBalanceException("Insufficient balance");
            }
            return DB::transaction(function () use ($dog, $request) {
                return UserDog::create([
                    'user_id' => $request->user()->id,
                    'dog_id' => $request->dog_id,
                    'name' => $dog->name,
                    'health_level' => $dog->health_level,
                    'hunger_level' => $dog->hunger_level,
                    'image_url' => $dog->image_url,
                    'price' => $dog->price,
                ]);
            });
        }else{
            throw new Exception('There is no such dog');
        }

    }

}
