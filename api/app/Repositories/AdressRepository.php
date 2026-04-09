<?php

namespace App\Repositories;

use App\Models\Adress;

class AdressRepository {
    public function createAdress (array $data) {
        Adress::create($data);
    }
}