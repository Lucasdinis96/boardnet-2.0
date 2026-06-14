<?php

namespace App\Http\Resources\Negotiation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WithdrawalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'status' => $this->status,
            'requested_at' => $this->requested_at?->format('d/m/Y'),
            'paid_at' => $this->paid_at?->format('d/m/Y'),
            'created_at' => $this->created_at?->format('d/m/Y'),
            'negotiation_id' => $this->negotiation_id
        ];
    }
}
