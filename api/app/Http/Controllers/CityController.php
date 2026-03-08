<?php

namespace App\Http\Controllers;

use App\Services\CityService;
use Illuminate\Http\Request;

class CityController extends Controller {
    protected $service;

    public function __construct(CityService $service) {
        $this->service = $service;
    }

    public function search(Request $request) {
        $term = $request->get('q', '');
        $cities = $this->service->searchCities($term);
        return response()->json($cities);
    }
}
