<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    /**
     * @throws Exception
     */
    public function register(RegisterRequest $request): UserResource
    {
        $response = $this->service->createUser($request);

        return (new UserResource($response['user']))->additional(['access_token' => $response['token']]);
    }

    /**
     * @throws Exception
     */
    public function login(LoginRequest $request): UserResource|JsonResponse
    {
        if (!Auth::attempt($request->only('id_telegram'))) {
            return response()->json(['error' => __('messages.failed')], 401);
        }

        // Retrieve the authenticated user
        $user = Auth::user();

        $token = $this->service->loginUser($user);
        return (new UserResource($user))->additional(['access_token' => $token]);
    }
}
