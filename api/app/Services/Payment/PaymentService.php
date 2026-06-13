<?php

namespace App\Services\Payment;

use App\Enums\NegotiationEventType;
use App\Enums\NegotiationStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentProvider;
use App\Enums\PaymentStatus;
use App\Models\Negotiation;
use App\Models\Payment;
use App\Repositories\Negotiation\NegotiationRepository;
use App\Repositories\Payment\PaymentRepository;
use App\Services\Negotiation\NegotiationEventService;
use App\Services\Payment\Contracts\PaymentProviderInterface;
use Illuminate\Support\Facades\Log;

class PaymentService {

    public function __construct(
        private PaymentRepository $paymentRepository,
        private NegotiationEventService $eventService,
        private NegotiationRepository $negotiationRepository,
        private PaymentProviderInterface $gateway

    ) {}

    public function createPendingPayment(Negotiation $negotiation, PaymentMethod $method): Payment {

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

        $providerResponse = match($method) {
            PaymentMethod::Pix => $this->gateway->createPixPayment($payment),
            PaymentMethod::CreditCard => $this->gateway->createCreditCardPayment($payment),
        };

        $this->paymentRepository
            ->update($payment, [
                'provider_payment_id' => $providerResponse['provider_payment_id'] ?? null,
                'transaction_id' => $providerResponse['transaction_id'] ?? null,
                'payment_url' => data_get($providerResponse,'provider_response.data.url'),
                'provider_response' => $providerResponse,
                'expires_at' => $providerResponse['expires_at'] ?? $payment->expires_at,
            ]);

        $payment->refresh();

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

    public function markAsPaid(Payment $payment, array $providerResponse = []): bool {
        Log::info($providerResponse);
        $updated = $this->paymentRepository
            ->update($payment, [
                'status' => PaymentStatus::Paid,
                'paid_amount' => $payment->amount,
                'paid_at' => now(),
                'receipt_url' => data_get($providerResponse,'data.checkout.receiptUrl'),
                'provider_response' => $providerResponse
            ]);
        
        $this->negotiationRepository->paid($payment->negotiation);

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

    public function expire(Payment $payment): bool {

        $updated = $this->paymentRepository
            ->update($payment, [
                'status' => PaymentStatus::Expired
            ]);

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