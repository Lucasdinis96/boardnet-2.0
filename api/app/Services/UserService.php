<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserService {
    protected UserRepository $repository;

    public function __construct(UserRepository $repository) {
        $this->repository = $repository;
    }

    public function getUser (Request $user) {
        Log::info($user);
        $this->repository->findUser($user->id);
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

    public function deleteAccount(User $user): void {
        $this->repository->deleteUser($user);
    }
}
