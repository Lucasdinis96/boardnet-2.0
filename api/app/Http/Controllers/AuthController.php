<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Models\Adress;
use App\Models\User;
use App\Services\RegisterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;




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
        ]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'data' => [
                'message' => 'Logout realizado com sucesso'
            ]
        ]);
    }

    public function me(Request $request) {
        return response()->json([
            'data' => new UserResource($request->user())
        ]);
    }

    public function register(RegisterRequest $request) {
        $request->validated();
        $this->registerService->createRegister($request);
        // User::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        //     'birthdate' => $request->birthdate,
        //     'city_id' => $request->city_id,
        //     'phone' => $request->phone
        // ]);

        // $user_id = User::get()->where('email', $request->email)->value('id');

        // Adress::create([
        //     'adress' => $request->adress_name,
        //     'number' => $request->adress_number,
        //     'neighborhood' => $request->neighborhood,
        //     'cep' => $request->cep,
        //     'city_id' => $request->city_id,
        //     'user_id' => $user_id
        // ]);

        

        // $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Usuário criado com sucesso'
            // 'token' => $token
        ], 201);
    }

    
}
