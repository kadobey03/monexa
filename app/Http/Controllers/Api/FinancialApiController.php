<?php

namespace App\Http\Controllers\Api;

use App\Services\FinancialService;
use App\Services\UserService;
use App\Http\Resources\BalanceResource;
use Illuminate\Http\JsonResponse;
use Exception;

class FinancialApiController extends Controller
{
    public function __construct(
        private FinancialService $financialService,
        private UserService $userService
    ) {}

    public function balance(): JsonResponse
    {
        try {
            $user = auth()->user();
            $balance = $this->userService->getUserBalance($user);

            return $this->successResponse(
                new BalanceResource($balance),
                'Balance retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve balance', 500);
        }
    }
}