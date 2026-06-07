<?php

namespace App\Http\Resources\Boardgames;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BoardgameTradeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'trade_id' => $this->trade_id,
            'value' => $this->value,
            'trade' => [
                'title' => $this->trade->title,
                'seller' => $this->trade->user->name
            ]

        ];
    }
}
