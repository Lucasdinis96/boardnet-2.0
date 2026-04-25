<?php

namespace App\Repositories;

use App\Models\City;
use App\Models\User;
use App\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserRepository {
    private $mailService;

    public function __construct (MailService $mailService) {
        $this->mailService = $mailService;
    }
    public function getAllCities() {
        return City::orderBy('name')->get();
    }

    public function createUser (array $data){
        User::create($data);
        $user = User::where('email', $data['email'])->first();
        return $user->toArray();
    }

    public function find($id){
        $user = User::where('id', $id)->first();
        return $user;
    }

    public function updateUser(User $user, array $data): void {
        $user->fill($data);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
            $this->mailService->verifyEmail($data); 
        }

        $user->save();
    }

    public function updateAdress (array $data, $id){
        User::where('id', $id)->update([
            'adress' => $data['adress'],
            'number' => $data['number'],
            'neighborhood' => $data['neighborhood'],
            'cep' => $data['cep'],
            'city_id' => $data['city_id'],
        ]);
    }

    public function updatePassword (string $newPassword, $id) {
        User::where('id', $id)->update([
            'password' => Hash::make($newPassword)
        ]);
        return true;
    }

    public function deleteUser($id){
        User::where('id', $id)->delete();
        return true;
    }

    public function getUserByEmail(string $email){
        return User::where('email', $email)->value('id');
    }

    public function verifyEmail(array $data){
        User::where('id', $data['id'])->where('email', $data['email'])->first()->update(['email_verified_at' => now()]);
    }
}
