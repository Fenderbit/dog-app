<?php

namespace App\Http\Controllers\Dog;

use App\Exceptions\InsufficientBalanceException;
use App\Http\Controllers\Controller;
use App\Http\Requests\DogBuyRequest;
use App\Http\Requests\DogRequest;
use App\Http\Requests\DogUpdateRequest;
use App\Http\Resources\UserDogResource;
use App\Http\Resources\UserResource;
use App\Models\Dog;
use App\Services\DogService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

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
    public function store(DogRequest $request): RedirectResponse
    {
        $this->service->create($request);

        session()->flash('success', 'Dog created successfully!');

        return redirect()->route('admin.add-dog');
    }

    public function index(): View
    {
        $dogs = Dog::all();
        return view('admin.dogs.index', compact('dogs'));
    }

    public function edit(Dog $dog): View
    {
        return view('admin.dogs.edit', compact('dog'));
    }

    /**
     * @throws Exception
     */
    public function update(DogUpdateRequest $request, Dog $dog): RedirectResponse
    {
        $this->service->update($request, $dog);
        session()->flash('success', 'Dog updated successfully!');
        return redirect()->route('admin.dogs.index');
    }

    public function destroy(Dog $dog): RedirectResponse
    {
        Storage::delete($dog->image_url);
        $dog->delete();
        session()->flash('success', 'Dog deleted successfully!');
        return redirect()->route('admin.dogs.index');
    }

    /**
     * @throws Exception
     */
    public function buy(DogBuyRequest $request): UserResource|JsonResponse
    {
        $user = $request->user();

        if ($user->dogs->isNotEmpty()) {
            return response()->json(['error' => 'User already have dog.'], 400);
        }

        try {
            $userDog = $this->service->createUserDog($request);
            $user->balance -= $userDog->price;
            $user->save();
        }catch (InsufficientBalanceException $e) {
            return $e->render($request);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        $userDogInfo = new UserDogResource($userDog);

        return (new UserResource($user))->additional(['dog' => $userDogInfo]);
    }


}
