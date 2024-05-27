<?php

namespace App\Http\Controllers\Food;

use App\Http\Controllers\Controller;
use App\Http\Requests\FoodRequest;
use App\Http\Resources\FoodResource;
use App\Services\FoodService;
use Exception;
use Illuminate\Http\Request;

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
    public function store(FoodRequest $request): FoodResource
    {
        $food = $this->service->create($request);

        return new FoodResource($food);
    }

}
