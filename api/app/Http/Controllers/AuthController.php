<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Services\RegisterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(RegisterService $registerService) {
        $this->registerService = $registerService;
    }

    public function login(LoginRequest $request) {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Credenciais inválidas'
            ], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => [
                'message' => 'Login realizado com sucesso',
                'token' => $token,
                'user' => new UserResource($request->user()),
            ]
        ], 200);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'data' => [
                'message' => 'Logout realizado com sucesso'
            ]
        ], 200);
    }

    public function me(Request $request) {
        return response()->json([
            'data' => new UserResource($request->user())
        ], 200);
    }

    public function register(RegisterRequest $request) {
        $request->validated();
        $this->registerService->createRegister($request);
        
        return response()->json([
            'message' => 'Usuário criado com sucesso',
        ], 201);
    }

    public function verifyEmail(Request $request){
        $respone = $this->registerService->verifyEmail($request->token);
    }

    
}
