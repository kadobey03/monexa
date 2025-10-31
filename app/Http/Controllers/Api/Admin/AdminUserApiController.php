<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Controller;
use App\Services\AdminService;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Exception;

class AdminUserApiController extends Controller
{
    public function __construct(
        private AdminService $adminService
    ) {}

    public function index(): JsonResponse
    {
        try {
            $users = $this->adminService->getAllUsers();

            return $this->paginatedResponse(
                $users,
                'Users retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve users', 500);
        }
    }

    public function show(int $userId): JsonResponse
    {
        try {
            $user = $this->adminService->getUser($userId);

            if (!$user) {
                return $this->errorResponse('User not found', 404);
            }

            return $this->successResponse(
                new UserResource($user),
                'User retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve user', 500);
        }
    }

    public function assignLead(int $userId): JsonResponse
    {
        try {
            $result = $this->adminService->assignLeadToAdmin($userId, auth()->user());

            if (!$result->success) {
                return $this->errorResponse($result->errorMessage, 422);
            }

            return $this->successResponse(
                new UserResource($result->user),
                'Lead assigned successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to assign lead', 500);
        }
    }
}