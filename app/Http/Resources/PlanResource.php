<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description ?? '',
            'min_investment' => number_format($this->price, 2),
            'expected_return' => number_format($this->total_return, 2),
            'return_percentage' => $this->getReturnPercentage(),
            'duration' => $this->total_duration,
            'increment_interval' => $this->increment_interval,
            'increment_type' => $this->increment_type,
            'is_featured' => $this->is_featured ?? false,
            'active_investors_count' => $this->whenCounted('activeInvestments'),
            'total_invested' => $this->whenLoaded('userPlans', function () {
                return number_format($this->userPlans->sum('amount'), 2);
            }),
        ];
    }
}