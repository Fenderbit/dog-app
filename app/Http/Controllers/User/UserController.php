<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserDogResource;
use App\Http\Resources\UserResource;
use App\Models\Food_purchase;
use App\Models\User;
use App\Models\UserDog;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function updateForApi(UserUpdateRequest $request): UserResource
    {
        $user = $this->service->update($request);

        return new UserResource($user);
    }

    public function showForApi(Request $request): UserResource
    {
        $user = $this->service->show($request);

        $userDog = UserDog::where('user_id', $user->id)->first();

        $userDogInfo = $userDog ? new UserDogResource($userDog) : null;

        return (new UserResource($user))->additional(['dog' => $userDogInfo]);
    }


    public function index(): View
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        $dogs = $user->dogs;
        $foodPurchases = $user->foods;
        return view('admin.users.show', compact('user', 'dogs', 'foodPurchases'));
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $user->update($request->all());
        return redirect()->route('admin.users.show', $user)->with('success', 'User updated successfully');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }

    public function addDog(Request $request, User $user): RedirectResponse
    {
        $user->dogs()->create($request->all());
        return redirect()->route('admin.users.show', $user)->with('success', 'Dog added successfully');
    }

    public function editDog(User $user, UserDog $dog)
    {
        return view('admin.users.edit_dog', compact('user', 'dog'));
    }

    public function updateDog(Request $request, User $user, UserDog $dog): RedirectResponse
    {
        $dog->update($request->all());
        return redirect()->route('admin.users.show', $user)->with('success', 'Dog updated successfully');
    }

    public function deleteDog(User $user, UserDog $dog): RedirectResponse
    {
        $dog->delete();
        return redirect()->route('admin.users.show', $user)->with('success', 'Dog deleted successfully');
    }

    public function createFood(User $user): View
    {
        return view('admin.users.create_food', compact('user'));
    }

    public function editFood(User $user, Food_purchase $food): View
    {
        return view('admin.users.edit_food', compact('user', 'food'));
    }

    public function addFood(Request $request, User $user): RedirectResponse
    {
        $data = $request->all();
        $data['is_consumed'] = $request->has('is_consumed') ? 1 : 0;

        $user->foods()->create($data);
        return redirect()->route('admin.users.show', $user)->with('success', 'Food added successfully');
    }

    public function updateFood(Request $request, User $user, Food_purchase $food): RedirectResponse
    {
        $food->update($request->all());
        return redirect()->route('admin.users.show', $user)->with('success', 'Food updated successfully');
    }

    public function deleteFood(User $user, Food_purchase $food): RedirectResponse
    {
        $food->delete();
        return redirect()->route('admin.users.show', $user)->with('success', 'Food deleted successfully');
    }
}
