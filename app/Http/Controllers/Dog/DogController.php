<?php

namespace App\Http\Controllers\Dog;

use App\Http\Controllers\Controller;
use App\Http\Requests\DogBuyRequest;
use App\Http\Requests\DogRequest;
use App\Http\Resources\DogResource;
use App\Http\Resources\RunInformationResource;
use App\Http\Resources\UserDogResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserDog;
use App\Services\DogService;
use Exception;
use Illuminate\Http\JsonResponse;

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

    /**
     * @throws Exception
     */
    public function buy(DogBuyRequest $request): UserResource|JsonResponse
    {
        $user = User::with('dogs')->where('id', $request->user()->id)->first();

        if ($user->dogs->isNotEmpty()) {
            return response()->json(['error' => 'User already have dog'], 400);
        }

        try {
            $userDog = $this->service->createUserDog($request);
            $user->balance -= $userDog->price;
            $user->save();
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }

        $userDogInfo = new UserDogResource($userDog);

        return (new UserResource($user))->additional(['dog' => $userDogInfo]);
    }
}
