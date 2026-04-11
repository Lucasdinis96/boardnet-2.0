<?php

namespace App\Services;

use App\Http\Resources\Adress\AdressCreateResource;
use App\Http\Resources\User\UserCreateResource;
use App\Repositories\AdressRepository;
use App\Repositories\UserRepository;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;


class RegisterService {
    private $userRepository;
    private $adressRepository;
    private $mailService;

    public function __construct(UserRepository $userRepository, AdressRepository $adressRepository, MailService $mailService) {
        $this->userRepository = $userRepository;
        $this->adressRepository = $adressRepository;
        $this->mailService = $mailService;
    }


    public function createRegister (Request $data) {
        $userData = UserCreateResource::make($data)->resolve();
        $userReturn = $this->userRepository->createUser($userData);
        $adressData = AdressCreateResource::make($data)->resolve();
        if ($adressData['user_id'] == null){
            $adressData['user_id'] = $this->userRepository->getUserByEmail($data->email);
        }
        $this->adressRepository->createAdress($adressData);
        $this->mailService->verifyEmail($userReturn); 

    }

    public function verifyEmail(string $token){
        $decrypt= Crypt::decrypt($token);
        $this->userRepository->verifyEmail($decrypt);
    }
}
