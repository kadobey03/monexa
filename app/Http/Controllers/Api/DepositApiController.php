<?php

namespace App\Http\Controllers\Api;

use App\Services\FinancialService;
use App\Http\Requests\Api\DepositRequest;
use App\Http\Resources\DepositResource;
use App\Http\Resources\DepositCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Exception;

class DepositApiController extends Controller
{
    public function __construct(
        private FinancialService $financialService
    ) {}

    public function index(): JsonResponse
    {
        try {
            $deposits = $this->financialService->getUserDeposits(auth()->user());

            return $this->successResponse(
                new DepositCollection($deposits),
                'Deposits retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve deposits', 500);
        }
    }

    public function store(DepositRequest $request): JsonResponse
    {
        try {
            $result = $this->financialService->processDeposit(
                $request->validated(),
                auth()->user()
            );

            if (!$result->success) {
                return $this->errorResponse($result->errorMessage, 422);
            }

            return $this->successResponse(
                new DepositResource($result->deposit),
                'Deposit processed successfully',
                201
            );
        } catch (Exception $e) {
            Log::error('Deposit API processing failed', ['error' => $e->getMessage()]);
            return $this->errorResponse('Deposit processing failed', 500);
        }
    }

    public function show(int $depositId): JsonResponse
    {
        try {
            $deposit = $this->financialService->getDeposit($depositId, auth()->user());

            if (!$deposit) {
                return $this->errorResponse('Deposit not found', 404);
            }

            return $this->successResponse(
                new DepositResource($deposit),
                'Deposit retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve deposit', 500);
        }
    }
}