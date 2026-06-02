<?php

namespace App\Http\Resources\Negotiation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NegotiationItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->boardgame->title,
            'price' => number_format($this->price, 2 ,',','')
        ];
    }
}
