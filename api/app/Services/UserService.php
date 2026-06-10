<?php

namespace App\Services;

use App\Http\Resources\Address\AddressGetResource;
use App\Http\Resources\Address\AddressUpdateResource;
use App\Http\Resources\User\UserGetResource;
use App\Models\User;
use App\Repositories\AddressRepository;
use App\Repositories\UserRepository;


class UserService {
    protected UserRepository $userRepository;
    protected AddressRepository $addressRepository;

    public function __construct(UserRepository $userRepository, AddressRepository $addressRepository) {
        $this->userRepository = $userRepository;
        $this->addressRepository = $addressRepository;
    }

    public function getUser (string $userId) {
       return UserGetResource::make($this->userRepository->find($userId));
    }

    public function getAddress (string $userId) {
       return AddressGetResource::make($this->userRepository->find($userId));
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

    public function updateAddress($data){
        $userId = $data->id;
        $addressData = AddressUpdateResource::make($data)->resolve();
        $this->userRepository->updateAddress($addressData, $userId);
        return true;
    }

    public function updatePassword(string $newPassword, $id) {
        return $this->userRepository->updatePassword($newPassword, $id);
    }

    public function deleteAccount($id) {
        return $this->userRepository->deleteUser($id);
    }

    public function updateAvatar(User $user, string $path) {
        return $this->userRepository->updateAvatar($user, $path);
    }
}
