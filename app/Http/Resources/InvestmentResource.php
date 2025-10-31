<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvestmentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'plan_id' => $this->plan_id,
            'amount' => number_format($this->amount, 2),
            'currency' => $this->currency ?? 'USD',
            'status' => $this->status,
            'start_date' => $this->created_at->toISOString(),
            'end_date' => $this->end_date?->toISOString(),
            'expected_return' => number_format($this->expected_return, 2),
            'current_return' => number_format($this->current_return, 2),
            'plan' => $this->whenLoaded('plan', function () {
                return [
                    'id' => $this->plan->id,
                    'name' => $this->plan->name,
                    'duration' => $this->plan->total_duration,
                ];
            }),
        ];
    }
}