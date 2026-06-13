<?php

namespace App\Http\Resources\Cart;

use App\Http\Resources\Trade\TradeItemResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
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
            'trade_item_id' => $this->trade_item_id,
            'trade_item' => new TradeItemResource(
                $this->whenLoaded('tradeItem')
            )
        ];;
    }
}
