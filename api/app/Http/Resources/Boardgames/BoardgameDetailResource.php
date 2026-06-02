<?php

namespace App\Http\Resources\boardgames;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BoardgameDetailResource extends JsonResource
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
            'publisher' => $this->publisher,
            'description' => $this->description,
        ];
    }
}
