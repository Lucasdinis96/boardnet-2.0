<?php

namespace App\Repositories;

use App\Models\City;
use App\Models\User;

class UserRepository {
    public function getAllCities() {
        return City::orderBy('name')->get();
    }

    public function findUser($id): ?User {
        $user = User::find($id)->all();
        return $user;
    }

    public function updateUser(User $user, array $data): void {
        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();
    }

    public function deleteUser(User $user): void {
        $user->delete();
    }
}
