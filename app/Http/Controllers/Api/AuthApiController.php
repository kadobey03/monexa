<?php

namespace App\Http\Controllers\Api;

use App\Services\UserService;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Exception;

class AuthApiController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->userService->authenticateUser($request->validated());

            if (!$result->success) {
                return $this->errorResponse($result->errorMessage, 401);
            }

            $token = $result->user->createToken('api-token')->plainTextToken;

            return $this->successResponse([
                'user' => new UserResource($result->user),
                'token' => $token,
                'token_type' => 'Bearer',
            ], 'Login successful');
        } catch (Exception $e) {
            return $this->errorResponse('Authentication failed', 401);
        }
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $result = $this->userService->createUser($request->validated());

            if (!$result->success) {
                return $this->errorResponse($result->errorMessage, 422);
            }

            $token = $result->user->createToken('api-token')->plainTextToken;

            return $this->successResponse([
                'user' => new UserResource($result->user),
                'token' => $token,
                'token_type' => 'Bearer',
            ], 'Registration successful', 201);
        } catch (Exception $e) {
            return $this->errorResponse('Registration failed', 422);
        }
    }

    public function logout(): JsonResponse
    {
        try {
            auth()->user()->currentAccessToken()->delete();

            return $this->successResponse(null, 'Logout successful');
        } catch (Exception $e) {
            return $this->errorResponse('Logout failed', 500);
        }
    }
}