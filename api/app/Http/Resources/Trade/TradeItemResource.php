<?php

namespace App\Http\Resources\Trade;

use App\Http\Resources\Boardgames\BoardgameResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TradeItemResource extends JsonResource
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
            'trade_id' => $this->trade_id,
            'value' => $this->value,
            'status' => $this->status,

            'seller' => [
                'id' => $this->trade?->user?->id,
                'name' => $this->trade?->user?->name,
            ],

            'boardgame' => new BoardgameResource(
                $this->whenLoaded('boardgame')
            )
        ];
    }
}
