<?php

namespace App\Http\Controllers;

use App\Http\Requests\Password\PasswordUpdateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use App\Services\CollectionService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Illuminate\View\View;

class UserController extends Controller {
    protected UserService $service;
    protected CollectionService $collectionService;

    public function __construct(UserService $service, CollectionService $collectionService) {
        $this->service = $service;
        $this->collectionService = $collectionService;
    }

    public function getUser($id){
        $user = $this->service->getUser($id);
        return response()->json(['data' => $user], 200);
    }

    public function getAdress($id){
        $adress = $this->service->getAdress($id);
        return response()->json([
            'data' => $adress
        ], 200);
    }

    public function updateAdress (Request $request) {
        $adress = $this->service->updateAdress($request);
        if ($adress){
            return response()->json([
                'data' => [
                    'message' => 'Endereço atualizada com sucesso',
                ]
            ], 201);
        }
    }

    public function updateUser(UserUpdateRequest $request) {
        $data = $this->service->updateUser($request->user(), $request->validated());

        return response()->json([
            'data' => [
                'message' => 'Conta atualizada com sucesso',
            ]
        ], 201);
    }

    public function updatePassword (PasswordUpdateRequest $request, $id){
        
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
                'message' => 'Senha atualizada com sucesso',
            ]
        ], 201);

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
                'message' => 'Conta Deletada com sucesso',
            ]
        ], 200);
    }

    public function checkPassword ($currentPassword, $id) {
        $user = User::find($id);
        return Hash::check($currentPassword, $user->password);
    }

    public function getCollection(int $id) {
        $collection = $this->collectionService->getUserCollection($id);
        return response()->json([
            'data' => $collection
        ], 200);
    }

    public function removeFromCollection(int $id){
        $remove =  $this->collectionService->removeFromCollection($id);

        return response()->json([
            'message' => 'Removido da coleção'
        ], 200);
    }
}
