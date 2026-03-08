<?php

namespace App\Services;

use App\Repositories\CityRepository;

class CityService
{
    protected $repository;

    public function __construct(CityRepository $repository) {
        $this->repository = $repository;
    }

    public function searchCities(string $term) {
        $cities = $this->repository->search($term);

        return $cities->map(function ($city) {
            return [
                'id' => $city->id,
                'name' => "{$city->name} - {$city->state->uf}",
            ];
        });
    }
}
