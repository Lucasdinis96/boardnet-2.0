<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\ProfileRepository;
use Illuminate\Support\Facades\Auth;

class ProfileService {
    protected ProfileRepository $repository;

    public function __construct(ProfileRepository $repository) {
        $this->repository = $repository;
    }

    public function getEditData(): array {
        $user = Auth::user();

        return compact('user');
    }

    public function updateProfile(User $user, array $data): void {
        if (isset($data['phone'])) {
            $digits = preg_replace('/\D/', '', $data['phone']);

            if (!str_starts_with($digits, '55')) {
                $digits = '55' . $digits;
            }

            $data['phone'] = $digits;
        }

        $this->repository->updateUser($user, $data);
    }

    public function deleteAccount(User $user): void {
        $this->repository->deleteUser($user);
    }
}
