<?php

namespace App\Http\Resources\Boardgames;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BoardgameGetResource extends JsonResource
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
            'title' => $this->title,
            'cover' => $this->cover,
            'min_players' => $this->min_players,
            'max_players' => $this->max_players,
            'age_range' => $this->age_range,
            'trade_item' => [
                'id' => $this->pivot?->id,
                'value' => $this->pivot?->value,
                'status' => $this->pivot?->status
            ],            
        ];
    }
}
