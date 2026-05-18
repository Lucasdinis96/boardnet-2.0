<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;

use App\Models\Negotiation;

use App\Services\Payment\PaymentService;

use Illuminate\Http\Request;

use App\Enums\PaymentMethod;

class PaymentController extends Controller {

    public function __construct(
        private PaymentService $paymentService
    ) {}

    /*
    |--------------------------------------------------------------------------
    | Cria pagamento
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request,
        int $negotiationId
    ) {

        $request->validate([

            'payment_method' => [
                'required',
                'string'
            ]
        ]);

        $negotiation = Negotiation::findOrFail(
            $negotiationId
        );

        /*
        |--------------------------------------------------------------------------
        | Segurança
        |--------------------------------------------------------------------------
        */

        if (
            $negotiation->buyer_id !==
            $request->user()->id
        ) {

            return response()->json([
                'message' => 'Negociação inválida'
            ], 403);
        }

        $payment = $this->paymentService
            ->createPendingPayment(

                negotiation: $negotiation,

                method: PaymentMethod::from(
                    $request->payment_method
                )
            );

        return response()->json([

            'message' => 'Pagamento criado com sucesso',

            'data' => $payment
        ]);
    }
}