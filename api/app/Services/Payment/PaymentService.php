<?php

namespace App\Services\Payment;

use App\Enums\NegotiationEventType;
use App\Enums\PaymentMethod;
use App\Enums\PaymentProvider;
use App\Enums\PaymentStatus;
use App\Models\Negotiation;
use App\Models\Payment;
use App\Repositories\Payment\PaymentRepository;
use App\Services\Negotiation\NegotiationEventService;
use App\Services\Payment\Contracts\PaymentProviderInterface;

class PaymentService {

    public function __construct(

        private PaymentRepository $paymentRepository,

        private NegotiationEventService $eventService,

        private PaymentProviderInterface $gateway

    ) {}

    /*
    |--------------------------------------------------------------------------
    | Cria pagamento pendente
    |--------------------------------------------------------------------------
    */

    public function createPendingPayment(
        Negotiation $negotiation,
        PaymentMethod $method
    ): Payment {

        /*
        |--------------------------------------------------------------------------
        | Cria pagamento local
        |--------------------------------------------------------------------------
        */

        $payment = $this->paymentRepository
            ->create([

                'negotiation_id' => $negotiation->id,

                'provider' => PaymentProvider::AbacatePay,

                'payment_method' => $method,

                'status' => PaymentStatus::Pending,

                'amount' => $negotiation->total,

                'currency' => 'BRL',

                'expires_at' => now()->addMinutes(15),
            ]);

        /*
        |--------------------------------------------------------------------------
        | Provider
        |--------------------------------------------------------------------------
        */

        $providerResponse = match($method) {

            PaymentMethod::Pix =>

                $this->gateway
                    ->createPixPayment($payment),

            PaymentMethod::CreditCard =>

                $this->gateway
                    ->createCreditCardPayment($payment),
        };

        /*
        |--------------------------------------------------------------------------
        | Atualiza payment
        |--------------------------------------------------------------------------
        */

        $this->paymentRepository
            ->update($payment, [

                'provider_payment_id' =>
                    $providerResponse['provider_payment_id']
                        ?? null,

                'transaction_id' =>
                    $providerResponse['transaction_id']
                        ?? null,

                'payment_url' =>
                    $providerResponse['payment_url']
                        ?? null,

                'provider_response' =>
                    $providerResponse,

                'expires_at' =>
                    $providerResponse['expires_at']
                        ?? $payment->expires_at,
            ]);

        /*
        |--------------------------------------------------------------------------
        | Refresh model
        |--------------------------------------------------------------------------
        */

        $payment->refresh();

        /*
        |--------------------------------------------------------------------------
        | Event
        |--------------------------------------------------------------------------
        */

        $this->eventService->create(

            negotiation: $negotiation,

            event: NegotiationEventType::PaymentPending,

            metadata: [

                'payment_id' => $payment->id,

                'method' => $method->value,

                'amount' => $payment->amount,
            ]
        );

        return $payment;
    }

    /*
    |--------------------------------------------------------------------------
    | Marca pagamento como pago
    |--------------------------------------------------------------------------
    */

    public function markAsPaid(
        Payment $payment,
        array $providerResponse = []
    ): bool {

        $updated = $this->paymentRepository
            ->update($payment, [

                'status' => PaymentStatus::Paid,

                'paid_amount' => $payment->amount,

                'paid_at' => now(),

                'provider_response' => $providerResponse
            ]);

        /*
        |--------------------------------------------------------------------------
        | Event
        |--------------------------------------------------------------------------
        */

        $this->eventService->create(

            negotiation: $payment->negotiation,

            event: NegotiationEventType::PaymentApproved,

            metadata: [

                'payment_id' => $payment->id,

                'amount' => $payment->amount
            ]
        );

        return $updated;
    }

    /*
    |--------------------------------------------------------------------------
    | Expira pagamento
    |--------------------------------------------------------------------------
    */

    public function expire(
        Payment $payment
    ): bool {

        $updated = $this->paymentRepository
            ->update($payment, [

                'status' => PaymentStatus::Expired
            ]);

        /*
        |--------------------------------------------------------------------------
        | Event
        |--------------------------------------------------------------------------
        */

        $this->eventService->create(

            negotiation: $payment->negotiation,

            event: NegotiationEventType::Expired,

            metadata: [

                'payment_id' => $payment->id
            ]
        );

        return $updated;
    }
}