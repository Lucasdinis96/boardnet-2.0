<?php

namespace App\Repositories;

use App\Models\City;
use App\Models\User;

class UserRepository {
    public function getAllCities() {
        return City::orderBy('name')->get();
    }

    public function createUser (array $data){
        User::create($data);
        $user = User::where('email', $data['email'])->first();
        return $user->toArray();
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

    public function getUserByEmail(string $email){
        return User::where('email', $email)->value('id');
    }

    public function verifyEmail(array $data){
        User::where('id', $data['id'])->where('email', $data['email'])->first()->update(['email_verified_at' => now()]);
    }
}
