<?php

namespace App\Services;

use App\Http\Resources\Adress\AdressCreateResource;
use App\Http\Resources\Adress\AdressGetResource;
use App\Http\Resources\Adress\AdressUpdateResource;
use App\Http\Resources\User\UserGetResource;
use App\Models\User;
use App\Repositories\AdressRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService {
    protected UserRepository $userRepository;
    protected AdressRepository $adressRepository;

    public function __construct(UserRepository $userRepository, AdressRepository $adressRepository) {
        $this->userRepository = $userRepository;
        $this->adressRepository = $adressRepository;
    }

    public function getUser (string $userId) {
       return UserGetResource::make($this->userRepository->find($userId));
    }

    public function getAdress (string $userId) {
       return AdressGetResource::make($this->userRepository->find($userId));
    }

    public function updateUser(User $user, array $data): void {
        if (isset($data['phone'])) {
            $digits = preg_replace('/\D/', '', $data['phone']);

            if (!str_starts_with($digits, '55')) {
                $digits = '55' . $digits;
            }

            $data['phone'] = $digits;
        }

        $this->repository->updateUser($user, $data);
    }

    public function updateAdress($data){
        $userId = $data->id;
        $adressData = AdressUpdateResource::make($data)->resolve();
        $this->userRepository->updateAdress($adressData, $userId);
        return true;
    }

    public function updatePassword(string $newPassword, $id) {
        return $this->userRepository->updatePassword($newPassword, $id);
    }

    public function deleteAccount($id) {
        return $this->userRepository->deleteUser($id);
    }
}
