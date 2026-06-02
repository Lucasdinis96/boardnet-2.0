<?php

namespace App\Http\Resources\Negotiation;

use App\Http\Resources\Boardgames\BoardgameGetResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class NegotiationGetResource extends JsonResource
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
            'seller' => $this->seller->name,
            'is_seller' => auth()->id() === $this->seller_id,
            'buyer' => $this->buyer->name,
            'status' => [
                'type' => $this->status->value,
                'label' => $this->status->label(),
            ],
            'items' => NegotiationItemResource::collection($this->whenLoaded('items')),
            'shipping_address' => [
                'street' => $this->shipping_address_snapshot['street'],
                'number' => $this->shipping_address_snapshot['number'],
                'neighborhood' => $this->shipping_address_snapshot['neighborhood'],
                'city_state' => $this->shipping_address_snapshot['city_state'],
                'zipcode' => $this->shipping_address_snapshot['zipcode']
                
            ],
            'tracking_code' => $this->tracking_code,
            'created_at' => $this->created_at?->format('d/m/Y'),
            'paid_at' => $this->paid_at?->format('d/m/Y'),
            'shipped_at' => $this->shipped_at?->format('d/m/Y'),
            'delivered_at' => $this->delivered_at?->format('d/m/Y'),
            'completed_at' => $this->completed_at?->format('d/m/Y'),
            'canceled_at' => $this->canceled_at?->format('d/m/Y'),
            'payments' => PaymentResource::collection($this->whenLoaded('payments'))
        ];
    }
}
