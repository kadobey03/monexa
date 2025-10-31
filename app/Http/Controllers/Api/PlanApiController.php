<?php

namespace App\Http\Controllers\Api;

use App\Services\PlanService;
use App\Http\Requests\Api\InvestmentRequest;
use App\Http\Resources\PlanResource;
use App\Http\Resources\PlanCollection;
use App\Http\Resources\InvestmentResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Exception;

class PlanApiController extends Controller
{
    public function __construct(
        private PlanService $planService
    ) {}

    public function index(): JsonResponse
    {
        try {
            $plans = $this->planService->getActivePlans();

            return $this->successResponse(
                new PlanCollection($plans),
                'Plans retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve plans', 500);
        }
    }

    public function show(int $planId): JsonResponse
    {
        try {
            $plan = $this->planService->getPlan($planId);

            if (!$plan) {
                return $this->errorResponse('Plan not found', 404);
            }

            return $this->successResponse(
                new PlanResource($plan),
                'Plan retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve plan', 500);
        }
    }

    public function invest(InvestmentRequest $request, int $planId): JsonResponse
    {
        try {
            $result = $this->planService->investInPlan(
                auth()->user(),
                $planId,
                $request->validated()
            );

            if (!$result->success) {
                return $this->errorResponse($result->errorMessage, 422);
            }

            return $this->successResponse(
                new InvestmentResource($result->investment),
                'Investment successful',
                201
            );
        } catch (Exception $e) {
            Log::error('Plan investment failed', ['error' => $e->getMessage()]);
            return $this->errorResponse('Investment failed', 500);
        }
    }

    public function myInvestments(): JsonResponse
    {
        try {
            $investments = $this->planService->getUserInvestments(auth()->user());

            return $this->successResponse(
                InvestmentResource::collection($investments),
                'Investments retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve investments', 500);
        }
    }
}