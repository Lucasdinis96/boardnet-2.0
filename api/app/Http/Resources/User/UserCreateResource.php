<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserCreateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'birthdate' => $request->birthdate,
            'city_id' => $request->city_id,
            'phone' => $request->phone,
            'address' => $request->address_name,
            'number' => $request->address_number,
            'neighborhood' => $request->neighborhood,
            'cep' => $request->cep
        ];
    }
}
