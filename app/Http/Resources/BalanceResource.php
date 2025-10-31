<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BalanceResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'account_balance' => number_format($this->account_bal, 2),
            'demo_balance' => number_format($this->demo_balance, 2),
            'total_invested' => number_format($this->totalInvested(), 2),
            'total_earnings' => number_format($this->totalEarnings(), 2),
            'currency' => 'USD',
            'last_updated' => now()->toISOString(),
        ];
    }
}