<?php

namespace App\Http\Resources\Trade;

use App\Http\Resources\Boardgames\BoardgameGetResource;
use App\Http\Resources\User\UserGetResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TradeDetailResource extends JsonResource
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
            'description' => $this->description,
            'user' => UserGetResource::make($this->whenLoaded('user')),
            'boardgames' => BoardgameGetResource::collection($this->whenLoaded('boardgames')),
            'images' => $this->whenLoaded('images')
        ];
    }
}
