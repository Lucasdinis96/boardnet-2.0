<?php

namespace App\Http\Resources\Boardgames;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BoardgameResource extends JsonResource
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
            'publisher' => $this->publisher,
            'release_date' => $this->release_date,
            'cover' => $this->cover,
        ];
    }
}
