<?php

namespace App\Http\Controllers\Payment;

use App\Enums\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Models\Negotiation;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller {

    public function __construct(
        private PaymentService $paymentService
    ) {}

    public function store(Request $request, int $negotiationId) {

        $request->validate([
            'payment_method' => ['required', 'string']
        ]);

        $negotiation = Negotiation::findOrFail($negotiationId);

        if (
            $negotiation->buyer_id !==
            $request->user()->id
        ) {

            return response()->json(['data' => [
                'message' => 'Negociação inválida'
            ]], 403);
        }

        $payment = $this->paymentService
            ->createPendingPayment(

                negotiation: $negotiation,

                method: PaymentMethod::from(
                    $request->payment_method
                )
            );

        return response()->json(['data' => [
            'payment' => $payment,
            'message' => 'Pagamento criado com sucesso',
        ]]);
    }
}