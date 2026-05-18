<?php

namespace App\Http\Controllers\Checkout;

use App\Enums\NegotiationEventType;
use App\Http\Controllers\Controller;
use App\Services\Checkout\CheckoutService;
use App\Services\Negotiation\NegotiationEventService;
use Illuminate\Http\Request;

class CheckoutController extends Controller {

    public function __construct(
        private CheckoutService $checkoutService,
        private NegotiationEventService $eventService
    ) {}

    public function store(Request $request) {

        $request->validate([
            'shipping_address' => ['required', 'array'],
            'shipping_address.street' => ['required', 'string'],
            'shipping_address.number' => ['required', 'string'],
            'shipping_address.neighborhood' => ['required', 'string'],
            'shipping_address.city' => ['required', 'string'],
            'shipping_address.state' => ['required', 'string'],
            'shipping_address.zipcode' => ['required', 'string'],
        ]);

        $negotiation = $this->checkoutService->checkout(
            user: $request->user(),
            shippingAddress: $request->shipping_address
        );

        return response()->json([
            'message' => 'Checkout realizado com sucesso',
            'data' => $negotiation
        ]);
    }
}