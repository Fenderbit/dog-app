<?php

namespace App\Services;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * @throws Exception
     */
    public function createUser(RegisterRequest $request): array
    {
        $response = [];
        try {
            $user = User::create($request->all());
            $token = $user->createToken('API token of ' . $user->name)->plainTextToken;
        } catch (\Exception) {
            throw new Exception(__('messages.create_error', ['attribute' => 'user']), 500);
        }

        $response['user'] = $user;
        $response['token'] = $token;

        return $response;
    }

    /**
     * @throws Exception
     */
    public function loginUser(Authenticatable $user)
    {
        try {
            $token = $user->createToken('API token of ' . $user->name)->plainTextToken;
        } catch (\Exception $e) {
            throw new Exception(__('messages.create_error', ['attribute' => 'token']) . $e->getMessage(), 500);
        }

        return $token;
    }
}
