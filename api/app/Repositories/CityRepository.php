<?php

namespace App\Repositories;

use App\Models\City;

class CityRepository {

    public function search(string $term) {
        return City::with('state')
            ->where('name', 'like', "%{$term}%")
            ->orderBy('id')
            ->get();
    }
}