<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Controller;
use App\Services\AdminService;
use Illuminate\Http\JsonResponse;
use Exception;

class AdminApiController extends Controller
{
    public function __construct(
        private AdminService $adminService
    ) {}

    public function dashboardStats(): JsonResponse
    {
        try {
            $stats = $this->adminService->getDashboardStats();

            return $this->successResponse(
                $stats,
                'Dashboard statistics retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve dashboard statistics', 500);
        }
    }
}