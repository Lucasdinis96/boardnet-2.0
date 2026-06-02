<?php

namespace App\Services;

use App\Http\Resources\Address\AddressCreateResource;
use App\Http\Resources\User\UserCreateResource;
use App\Repositories\AddressRepository;
use App\Repositories\UserRepository;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;


class RegisterService {
    private $userRepository;
    private $addressRepository;
    private $mailService;

    public function __construct(UserRepository $userRepository, AddressRepository $addressRepository, MailService $mailService) {
        $this->userRepository = $userRepository;
        $this->addressRepository = $addressRepository;
        $this->mailService = $mailService;
    }


    public function createRegister (Request $data) {
        $userData = UserCreateResource::make($data)->resolve();
        $userReturn = $this->userRepository->createUser($userData);
        $this->mailService->verifyEmail($userReturn);
        return true;
    }

    public function verifyEmail(string $token){
        $decrypt= Crypt::decrypt($token);
        $this->userRepository->verifyEmail($decrypt);
    }
}
