<?php

namespace App\Http\Controllers\Checkout;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Checkout\CheckoutService;
use App\Services\Negotiation\NegotiationEventService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller {

    public function __construct(
        private CheckoutService $checkoutService,
        private NegotiationEventService $eventService

    ) {}

    public function store(Request $request) {

        if ($request->use_registered_address) {
            $address = [ 
                'shipping_address' => [
                    'street' => $request->user()->address,
                    'number' => $request->user()->number,
                    'neighborhood' => $request->user()->neighborhood,
                    'city_state' => $request->user()->city->name.' - '.$request->user()->city->state->uf,
                    'zipcode' => $request->user()->cep
                ]];
        } else {
            $address = $request->validate([
                'shipping_address' => ['required', 'array'],
                'shipping_address.street' => ['required', 'string'],
                'shipping_address.number' => ['required', 'string'],
                'shipping_address.neighborhood' => ['required', 'string'],
                'shipping_address.city_state' => ['required', 'string'],
                'shipping_address.zipcode' => ['required', 'string'],
            ]);
        }

        $negotiation = $this->checkoutService->checkout(
            user: $request->user(),
            shippingAddress: $address
        );

        return response()->json([
            'data' => [
                'negotiation' => $negotiation,
                'message' => 'Negociação iniciada com sucesso.',
            ], 201
        ]);
    }
}