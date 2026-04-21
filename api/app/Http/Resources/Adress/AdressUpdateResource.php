<?php

namespace App\Http\Resources\Adress;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdressUpdateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'adress' => $request->adress,
            'number' => $request->number,
            'neighborhood' => $request->neighborhood,
            'cep' => $request->cep,
            'city_id' => $request->city_id,
        ];
    }
}
