<?php

namespace App\Http\Controllers\Negotiation;

use App\Http\Controllers\Controller;
use App\Http\Resources\Negotiation\NegotiationGetResource;
use App\Models\Negotiation;
use App\Services\Negotiation\NegotiationService;
use App\Support\PaginatedResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NegotiationController extends Controller {

    use ApiResponse;

    public function __construct(
        private NegotiationService $negotiationService
    ) {}

    public function index(Request $request) {
        $negotiations = $this->negotiationService->getAllUserNegotiations($request->user());
        return response()->json([
            'data' => $negotiations
            ]);
    }

    public function getUserNegotiationAsBuyer(Request $request) {
        $negotiations = $this->negotiationService->getUserNegotiationsAsBuyer($request->user());
        $response = PaginatedResource::make($negotiations, NegotiationGetResource::class);
        return $this->successResponse(
            $response,
            'Compras carregados com sucesso.'
        );  
    }

    public function getUserNegotiationAsSeller(Request $request) {
        $negotiations = $this->negotiationService->getUserNegotiationsAsSeller($request->user());
        $response = PaginatedResource::make($negotiations, NegotiationGetResource::class);
        return $this->successResponse(
            $response,
            'Vendas carregados com sucesso.'
        ); 
    }


    public function show(Request $request, int $id) {
        $negotiation = $this->negotiationService->getNegotiation(user: $request->user(), negotiationId: $id);
        return response()->json([
            'data' => $negotiation
            ]);
    }

    public function shipped(Request $request, int $id) {
        $shippingInfo = $request->validate([
            'shipping_company' => ['required', 'string'],
            'tracking_code' => ['required', 'string']
        ]);
        $negotiation = Negotiation::findOrFail($id);
        $confirmed = $this->negotiationService->shipped($shippingInfo, $negotiation);
        if ($confirmed) {
            return response()->json([
                'data' => [
                    'message' => "Envio confirmado"
                ]
            ]);
        }
    }

    public function delivered(Request $request) {
        $negotiation = Negotiation::findOrFail($request->id);
        $confirmed = $this->negotiationService->delivered($negotiation);
        if ($confirmed) {
            return response()->json([
                'data' => [
                    'message' => "Recebimento confirmado"
                ]
            ]);
        }
    }
}