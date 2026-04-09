<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserController extends Controller {
    protected UserService $service;

    public function __construct(UserService $service) {
        $this->service = $service;
    }

    public function update(UserUpdateRequest $request) {
        $data = $this->service->updateProfile($request->user(), $request->validated());

        return response()->json([
            'status' => 'sucess',
            'message' => 'Conta atualizada com sucesso',
            'data' => $data
        ]);
    }

    public function destroy(Request $request): RedirectResponse {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();

        $this->service->deleteAccount($user);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
