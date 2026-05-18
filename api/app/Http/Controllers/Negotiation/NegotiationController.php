<?php

namespace App\Http\Controllers\Negotiation;

use App\Http\Controllers\Controller;
use App\Services\Negotiation\NegotiationService;

use Illuminate\Http\Request;

class NegotiationController extends Controller {

    public function __construct(
        private NegotiationService $negotiationService
    ) {}

    /*
    |--------------------------------------------------------------------------
    | Lista negociações do usuário
    |--------------------------------------------------------------------------
    */

    public function index(Request $request) {

        $negotiations = $this->negotiationService
            ->getUserNegotiations(
                $request->user()
            );

        return response()->json($negotiations);
    }

    /*
    |--------------------------------------------------------------------------
    | Exibe negociação específica
    |--------------------------------------------------------------------------
    */

    public function show(
        Request $request,
        int $id
    ) {

        $negotiation = $this->negotiationService
            ->getNegotiation(
                user: $request->user(),
                negotiationId: $id
            );

        return response()->json($negotiation);
    }
}