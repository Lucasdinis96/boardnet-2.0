<?php

namespace App\Repositories;

use App\Models\City;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisteredUserRepository {
    
    public function getAllCities() {
        return City::orderBy('name')->get();
    }

    public function createUser(array $data): User {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'birthdate' => $data['birthdate'] ?? null,
            'phone' => $data['phone'] ?? null,
            'city_id' => $data['city_id'] ?? null,
        ]);
    }
}
