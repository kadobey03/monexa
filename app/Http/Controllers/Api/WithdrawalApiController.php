<?php

namespace App\Http\Controllers\Api;

use App\Services\FinancialService;
use App\Http\Requests\Api\WithdrawalRequest;
use App\Http\Resources\WithdrawalResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Exception;

class WithdrawalApiController extends Controller
{
    public function __construct(
        private FinancialService $financialService
    ) {}

    public function index(): JsonResponse
    {
        try {
            $withdrawals = $this->financialService->getUserWithdrawals(auth()->user());

            return $this->successResponse(
                WithdrawalResource::collection($withdrawals),
                'Withdrawals retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve withdrawals', 500);
        }
    }

    public function store(WithdrawalRequest $request): JsonResponse
    {
        try {
            $result = $this->financialService->processWithdrawal(
                $request->validated(),
                auth()->user()
            );

            if (!$result->success) {
                return $this->errorResponse($result->errorMessage, 422);
            }

            return $this->successResponse(
                new WithdrawalResource($result->withdrawal),
                'Withdrawal processed successfully',
                201
            );
        } catch (Exception $e) {
            Log::error('Withdrawal API processing failed', ['error' => $e->getMessage()]);
            return $this->errorResponse('Withdrawal processing failed', 500);
        }
    }

    public function show(int $withdrawalId): JsonResponse
    {
        try {
            $withdrawal = $this->financialService->getWithdrawal($withdrawalId, auth()->user());

            if (!$withdrawal) {
                return $this->errorResponse('Withdrawal not found', 404);
            }

            return $this->successResponse(
                new WithdrawalResource($withdrawal),
                'Withdrawal retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve withdrawal', 500);
        }
    }
}