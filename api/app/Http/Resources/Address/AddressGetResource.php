<?php

namespace App\Http\Resources\Address;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressGetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'address' => $this->address,
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
