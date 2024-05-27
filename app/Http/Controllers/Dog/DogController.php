<?php

namespace App\Http\Controllers\Dog;

use App\Http\Controllers\Controller;
use App\Http\Requests\DogRequest;
use App\Http\Resources\DogResource;
use App\Services\DogService;
use Exception;

class DogController extends Controller
{
    private DogService $service;

    public function __construct(DogService $service)
    {
        $this->service = $service;
    }

    /**
     * @throws Exception
     */
    public function store(DogRequest $request): DogResource
    {
        $dog = $this->service->create($request);

        return new DogResource($dog);
    }
}
