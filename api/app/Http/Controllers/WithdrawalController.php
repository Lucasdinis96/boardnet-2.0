<?php

namespace App\Http\Controllers;

use App\Enums\WithdrawalStatus;
use App\Http\Resources\Negotiation\WithdrawalResource;
use App\Models\Withdrawal;
use App\Support\PaginatedResource;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WithdrawalController extends Controller
{

    use ApiResponse;
    
    public function index() {
        $withdrawal = Withdrawal::query()
            ->where('user_id', auth()->id())
            ->with('negotiation')
            ->latest()
            ->paginate(6);
        $response = PaginatedResource::make($withdrawal, WithdrawalResource::class);
        return $this->successResponse(
            $response,
            'Saques carregados com sucesso.'
        ); 
    }

    public function request(Withdrawal $withdrawal) {
        if ($withdrawal->user_id !== auth()->id()) {
            abort(403);
        }

        
        $user = auth()->user();

        if (empty($user->pix_key) || empty($user->pix_key_type)) {
            throw new HttpException (422, 'Cadastre uma chave PIX antes de solicitar saque.');
        }

        if ($withdrawal->status !== WithdrawalStatus::AVAILABLE) {
            throw new HttpException(422, 'Saque indisponível');
        }

        $withdrawal->update([
            'status' => WithdrawalStatus::REQUESTED,
            'requested_at' => now()
        ]);

        return response()->json([ 'data' => [
            'message' => 'Solicitação de saque enviada.'
        ]]);
    }
}
