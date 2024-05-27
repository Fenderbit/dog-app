<?php

namespace App\Services;

use App\Http\Requests\FoodRequest;
use App\Models\Food;
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

        return DB::transaction(function () use ($validatedData) {
            return Food::create($validatedData);
        });
    }
}
