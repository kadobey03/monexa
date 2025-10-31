<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'phone_number' => $this->phone_number,
            'country' => $this->country,
            'balance' => number_format($this->account_bal, 2),
            'demo_balance' => number_format($this->demo_balance, 2),
            'kyc_status' => $this->kyc_status ?? 'pending',
            'email_verified_at' => $this->email_verified_at?->toISOString(),
            'created_at' => $this->created_at->toISOString(),

            // Lead information (admin context only)
            'lead_info' => $this->when(auth()->check() && auth()->user()->username === 'admin', [
                'lead_status' => $this->lead_status,
                'lead_score' => $this->lead_score,
                'assigned_admin' => $this->whenLoaded('assignedAdmin', function () {
                    return $this->assignedAdmin->name ?? 'Unassigned';
                }),
            ]),
        ];
    }
}