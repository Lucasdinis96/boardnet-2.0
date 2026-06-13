<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Cart\CartItemResource;

class CartGetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource['cart']->id,
            'items' => CartItemResource::collection(
                $this->resource['cart']->items
            ),
            'subtotal' => $this['subtotal'],
            'shipping' => $this['shipping'],
            'total' => $this['total'],
        ];
    }
}
