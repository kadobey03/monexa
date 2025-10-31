<?php

namespace App\Http\Controllers\Api;

use App\Services\UserService;
use App\Http\Requests\Api\UpdateProfileRequest;
use App\Http\Requests\Api\KycUploadRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Exception;

class UserApiController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    public function profile(): JsonResponse
    {
        try {
            $user = auth()->user();

            return $this->successResponse(
                new UserResource($user),
                'Profile retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve profile', 500);
        }
    }

    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        try {
            $result = $this->userService->updateProfile(
                auth()->user(),
                $request->validated()
            );

            if (!$result->success) {
                return $this->errorResponse($result->errorMessage, 422);
            }

            return $this->successResponse(
                new UserResource($result->user),
                'Profile updated successfully'
            );
        } catch (Exception $e) {
            Log::error('Profile update failed', ['error' => $e->getMessage()]);
            return $this->errorResponse('Profile update failed', 500);
        }
    }

    public function uploadKyc(KycUploadRequest $request): JsonResponse
    {
        try {
            $result = $this->userService->uploadKycDocument(
                auth()->user(),
                $request->validated()
            );

            if (!$result->success) {
                return $this->errorResponse($result->errorMessage, 422);
            }

            return $this->successResponse(
                $result->document,
                'KYC document uploaded successfully'
            );
        } catch (Exception $e) {
            Log::error('KYC upload failed', ['error' => $e->getMessage()]);
            return $this->errorResponse('KYC upload failed', 500);
        }
    }

    public function kycStatus(): JsonResponse
    {
        try {
            $status = $this->userService->getKycStatus(auth()->user());

            return $this->successResponse(
                $status,
                'KYC status retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve KYC status', 500);
        }
    }
}