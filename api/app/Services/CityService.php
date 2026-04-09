<?php

namespace App\Services;

use App\Repositories\CityRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CityService
{
    protected $repository;

    public function __construct(CityRepository $repository) {
        $this->repository = $repository;
    }

    public function searchCities(Request $data) {
        $term = $data->name;
        $cities = $this->repository->search($term);

        return $cities->map(function ($city) {
            return [
                'id' => $city->id,
                'name' => "{$city->name} - {$city->state->uf}",
            ];
        });
    }
}
