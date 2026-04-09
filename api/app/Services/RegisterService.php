<?php

namespace App\Services;

use App\Http\Resources\Adress\AdressCreateResource;
use App\Http\Resources\User\UserCreateResource;
use App\Repositories\AdressRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RegisterService {
    private $userRepository;
    private $adressRepository;

    public function __construct(UserRepository $userRepository, AdressRepository $adressRepository) {
        $this->userRepository = $userRepository;
        $this->adressRepository = $adressRepository;
    }


    public function createRegister (Request $data) {
        $userData = UserCreateResource::make($data)->resolve();
        $this->userRepository->createUser($userData);
        $adressData = AdressCreateResource::make($data)->resolve();
        if ($adressData['user_id'] == null){
            $adressData['user_id'] = $this->userRepository->getUserByEmail($data->email);
        }
        $this->adressRepository->createAdress($adressData);
    }
}
