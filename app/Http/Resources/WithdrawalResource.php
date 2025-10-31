<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WithdrawalResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'amount' => number_format($this->amount, 2),
            'currency' => $this->currency ?? 'USD',
            'payment_method' => $this->payment_method,
            'status' => $this->status,
            'wallet_address' => $this->wallet_address,
            'transaction_id' => $this->transaction_id,
            'fees' => $this->fees ? number_format($this->fees, 2) : '0.00',
            'net_amount' => $this->getNetAmount(),
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
        ];
    }
}