<?php

namespace App\Http\Controllers\Negotiation;

use App\Http\Controllers\Controller;
use App\Http\Resources\Negotiation\NegotiationGetResource;
use App\Models\Negotiation;
use App\Services\Negotiation\NegotiationService;
use Illuminate\Http\Request;

class NegotiationController extends Controller {

    public function __construct(
        private NegotiationService $negotiationService
    ) {}

    public function index(Request $request) {

        $negotiations = $this->negotiationService
            ->getAllUserNegotiations(
                $request->user()
            );

        return response()->json([
            'data' => $negotiations
            ]);
    }

    public function getUserNegotiationAsBuyer(Request $request) {

        $negotiations = $this->negotiationService
            ->getUserNegotiationsAsBuyer(
                $request->user()
            );

        return response()->json([
            'data' => NegotiationGetResource::collection($negotiations)
            ]);
    }

    public function getUserNegotiationAsSeller(Request $request) {

        $negotiations = $this->negotiationService
            ->getUserNegotiationsAsSeller(
                $request->user()
            );

        return response()->json([
            'data' => NegotiationGetResource::collection($negotiations)
            ]);
    }


    public function show(Request $request, int $id) {

        $negotiation = $this->negotiationService
            ->getNegotiation(
                user: $request->user(),
                negotiationId: $id
            );

        return response()->json([
            'data' => $negotiation
            ]);
    }

    public function shipped(Request $request, int $id) {
        $request->validate([
            'tracking_code' => ['required', 'string']
        ]);

        $negotiation = Negotiation::findOrFail($id);

        $confirmed = $this->negotiationService->shipped($request->tracking_code, $negotiation);

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