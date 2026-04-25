<?php

namespace App\Http\Resources\Collection;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollectionGetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'collection_id' => $this->id,
            'boardgame' => [
                'id' => $this->boardgame_id,
                'title' => $this->boardgame?->title,
                'cover' => $this->boardgame?->cover
            ]
        ];
    }
}
