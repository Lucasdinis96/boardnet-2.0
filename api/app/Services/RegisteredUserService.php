<?php

namespace App\Services;

use App\Repositories\RegisteredUserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;

class RegisteredUserService {
    protected RegisteredUserRepository $repository;

    public function __construct(RegisteredUserRepository $repository) {
        $this->repository = $repository;
    }

    public function getRegisterData(): array {
        $cities = $this->repository->getAllCities();
        return compact('cities');
    }

    public function register(array $data) {
        $user = $this->repository->createUser($data);
        event(new Registered($user));
        Auth::login($user);

        return $user;
    }
}
