<?php

namespace App\Http\Resources\Address;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressUpdateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'address' => $request->address,
            'number' => $request->number,
            'neighborhood' => $request->neighborhood,
            'cep' => $request->cep,
            'city_id' => $request->city_id,
        ];
    }
}
