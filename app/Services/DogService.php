<?php

namespace App\Services;

use App\Http\Requests\DogRequest;
use App\Models\Dog;
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

}
