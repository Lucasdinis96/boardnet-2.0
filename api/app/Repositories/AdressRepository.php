<?php

namespace App\Repositories;

use App\Models\Adress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdressRepository {
    public function createAdress (array $data) {
        Adress::create($data);
    }

    public function getAdress($adressId){
        return Adress::where('user_id', $adressId)->first();
    }
}