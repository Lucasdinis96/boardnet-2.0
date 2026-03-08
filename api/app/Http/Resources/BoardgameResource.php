<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BoardgameResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'players'   => $this->players,
            'playtime'  => $this->playtime,
            'age_range' => $this->age_range,

            'value'     => $this->pivot?->value,
        ];
    }
}
