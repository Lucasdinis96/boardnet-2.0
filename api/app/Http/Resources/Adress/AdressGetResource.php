<?php

namespace App\Http\Resources\Adress;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdressGetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'adress' => $this->adress,
            'number' => $this->number,
            'neighborhood' => $this->neighborhood,
            'cep' => $this->cep,
            'city' => [
                'id' => $this->city_id,
                'name' => $this->city->name,
                'state' => $this->city->state?->uf,
            ]
        ];
    }
}
