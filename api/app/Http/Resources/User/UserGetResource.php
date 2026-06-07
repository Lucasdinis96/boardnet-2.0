<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserGetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name'  => $this->name,
            'email' => $this->email,
            'birthdate' => $this->birthdate,
            'phone' => $this->phone,
            'city_state' => $this->city->name.' - '.$this->city->state->uf
        ];
    }
}
