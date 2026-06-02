<?php

namespace App\Repositories;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AddressRepository {
    public function createAddress (array $data) {
        Address::create($data);
    }

    public function getAddress($addressId){
        return Address::where('user_id', $addressId)->first();
    }
}