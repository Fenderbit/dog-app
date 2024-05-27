<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
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
    public function register(RegisterRequest $request): UserResource|JsonResponse
    {
        $apiKey = $request->header('Authorization');

        if (strcmp($apiKey, env('API_KEY'))) {
            return response()->json(["error" => __('messages.api_key_error')], 400);
        }

        $response = $this->service->createUser($request);

        return (new UserResource($response['user']))->additional(['access_token' => $response['token']]);
    }

    /**
     * @throws Exception
     */
    public function login(LoginRequest $request): UserResource|JsonResponse
    {
        $apiKey = $request->header('Authorization');

        if (strcmp($apiKey, env('API_KEY'))) {
            return response()->json(["error" => __('messages.api_key_error')], 400);
        }

        $user = User::where('id_telegram', $request->id_telegram)->first();

        if (!$user) {
            return response()->json(['error' => __('messages.failed')], 401);
        }

        Auth::login($user);

        $token = $this->service->loginUser($user);

        return (new UserResource($user))->additional(['access_token' => $token]);
    }

}
