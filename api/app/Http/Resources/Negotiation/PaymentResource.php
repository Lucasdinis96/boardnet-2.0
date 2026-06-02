<?php

namespace App\Http\Resources\Negotiation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'negotiation_id' => $this->negotiation_id,
            'method' => $this->payment_method->label(),
            'status' => [
                'type' => $this->status->value,
                'label' => $this->status->label()
            ],
            'amount' => $this->amount,
            'payment_url' => $this->payment_url,
            'receipt_url' => $this->receipt_url,
            'created_at' => $this->created_at?->format('d/m/Y'),
            'paid_at' => $this->paid_at?->format('d/m/Y')
        ];
    }
}
