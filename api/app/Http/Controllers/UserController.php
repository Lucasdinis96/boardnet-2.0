<?php

namespace App\Http\Controllers;

use App\Http\Requests\Password\PasswordUpdateRequest;
use App\Http\Requests\Trade\TradeCreateRequest;
use App\Http\Requests\Trade\TradeUpdateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\Trade;
use App\Models\User;
use App\Services\CollectionService;
use App\Services\Image\ImageUploadService;
use App\Services\TradeService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;


class UserController extends Controller {
    protected UserService $userService;
    protected CollectionService $collectionService;
    protected TradeService $tradeService;
    protected ImageUploadService $uploadService;

    public function __construct(UserService $userService, CollectionService $collectionService, TradeService $tradeService, ImageUploadService $uploadService) {
        $this->userService = $userService;
        $this->collectionService = $collectionService;
        $this->tradeService = $tradeService;
        $this->uploadService = $uploadService;
    }

    public function getUser($id){
        $user = $this->userService->getUser($id);
        return response()->json(['data' => $user], 200);
    }

    public function getAddress($id){
        $address = $this->userService->getAddress($id);
        return response()->json([
            'data' => $address
        ], 200);
    }

    public function updateAddress (Request $request) {
        $address = $this->userService->updateAddress($request);
        if ($address){
            return response()->json([
                'data' => [
                    'message' => 'Endereço atualizada com sucesso',
                ]
            ], 201);
        }
    }

    public function updateUser(UserUpdateRequest $request) {
        $data = $this->userService->updateUser($request->user(), $request->validated());

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
        $this->userService->updatePassword($request->newPassword, $id);
        return response()->json([
            'data' => [
                'message' => 'Senha atualizada com sucesso',
            ]
        ], 201);

    }

    public function destroy(Request $request, $id) {
        $checkPassword = $this->checkPassword($request->password, $id);
        if (!$checkPassword) {
            throw new Exception('Senha Incorreta!!');
        }
        $this->userService->deleteAccount($id);

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
//-----------------------------------------------------------------------
    //Collection Section
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
//-----------------------------------------------------------------------
    //Trade Section
    public function getTrades(int $request) {
        $trades = $this->tradeService->getUserTrades($request);
        return response()->json([
            'data' => $trades
        ]);    
    }

    public function showTrade(int $request){
        $trade = $this->tradeService->showTrade($request);
        return response()->json([
            'data' => $trade
        ], 200);
    }

    public function createTrade(TradeCreateRequest $request) {
        $trade = $this->tradeService->createTrade($request->validated(), $request->file('images'));
        
        if(!$trade) {
            return response()->json([
            'data' => [
                'message' => 'Falha ao criar o anúncio'
            ]
            ], 422);
        }

        return response()->json([
            'data' => [
                'message' => 'Anúncio criado com sucesso'
            ]
        ], 201);
    }

    public function updateTrade(TradeUpdateRequest $request, Trade $trade) {
        $trade = $this->tradeService->updateTrade($request->validated(), $trade, $request->file('images'));

        if (!$trade) {
            return response()->json([
                'data' => ['message' => 'Erro ao atualizar o anuncio.']
            ], 422);
        }
        
        return response()->json([
            'data' => ['message' => 'Anúncio editado com sucesso.']
        ], 201);
    }

    public function deleteTrade(int $request) {
        $this->tradeService->deleteTrade($request);
        return response()->json([
            'status' => 'success',
            'message' => 'Anúncio deletado com sucesso.'
        ]);
    }

    public function detachBoardgame(Request $trade) {
        $this->tradeService->removeBoardgame($trade);
        return response()->json([
            'status' => 'success',
            'message' => 'Jogo deletado com sucesso.'
        ]);    }

    public function updateAvatar(Request $request, ImageUploadService $uploadService) {
        $user = $request->user();
        $request->validate([
            'image' => 'required|image|max:10240'
        ]);
        
        $path = $uploadService->upload($request->file('image'), "avatars/{$user->id}", 'avatar');

        $savedPath = $this->userService->updateAvatar($request->user(), $path);

        return response()->json(['data' => [
            'message' => 'Avatar atualizado',
            'path' => $savedPath
        ]
        ]);
}
}
