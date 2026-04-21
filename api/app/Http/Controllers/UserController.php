<?php

namespace App\Http\Controllers;

use App\Http\Requests\Password\PasswordUpdateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserController extends Controller {
    protected UserService $service;

    public function __construct(UserService $service) {
        $this->service = $service;
    }

    public function getUser($id){
        $user = $this->service->getUser($id);
        return response()->json(($user));
    }

    public function getAdress($id){
        $adress = $this->service->getAdress($id);
        return response()->json($adress);
    }

    public function updateAdress (Request $request) {
        $adress = $this->service->updateAdress($request);
        if ($adress){
            return response()->json([
                'data' => [
                    'status' => 'sucess',
                    'message' => 'Conta atualizada com sucesso',
                ]
            ]);
        }
    }

    public function updateUser(UserUpdateRequest $request) {
        $data = $this->service->updateUser($request->user(), $request->validated());

        return response()->json([
            'data' => [
                'status' => 'sucess',
                'message' => 'Conta atualizada com sucesso',
            ]
        ]);
    }

    public function updatePassword (PasswordUpdateRequest $request, $id){
        // $user = User::find($id);
        // if (!Hash::check($request->input('currentPassword'), $user->password)) {
        //     return response()->json([
        //     'data' => [
        //         'status' => 'sucess',
        //         'message' => 'Senha Atual está incorreta',
        //     ]
        //     ]);
        // }
        $checkPassword = $this->checkPassword($request->currentPassword, $id);
        if (!$checkPassword) {
            return response()->json([
                'data' => [
                    'message' => 'Senha Atual está incorreta',
                ]
            ], 422);
        }
        $this->service->updatePassword($request->newPassword, $id);
        return response()->json([
            'data' => [
                'status' => 'sucess',
                'message' => 'Senha atualizada com sucesso',
            ]
        ]);

    }

    public function destroy(Request $request, $id) {
        $checkPassword = $this->checkPassword($request->password, $id);
        if (!$checkPassword) {
            return response()->json([
                'data' => [
                    'message' => 'Senha incorreta',
                ]
            ], 422);
        }
        $this->service->deleteAccount($id);

        return response()->json([
            'data' => [
                'status' => 'sucess',
                'message' => 'Conta Deletada com sucesso',
            ]
        ]);
    }

    public function checkPassword ($currentPassword, $id) {
        $user = User::find($id);
        return Hash::check($currentPassword, $user->password);
    }
}
