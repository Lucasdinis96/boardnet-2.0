<?php

namespace App\Http\Controllers;

use App\Services\CityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CityController extends Controller {
    protected $service;

    public function __construct(CityService $service) {
        $this->service = $service;
    }

    public function search(Request $request) {

        $cities = $this->service->searchCities($request);
        return response()->json([
            'data' => $cities
        ]);
    }
}
