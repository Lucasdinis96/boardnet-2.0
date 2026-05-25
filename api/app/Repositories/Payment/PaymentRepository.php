<?php

namespace App\Repositories\Payment;

use App\Models\Payment;

class PaymentRepository {

    public function create(array $data): Payment {

        return Payment::create($data);
    }

    public function findById(int $id): ?Payment {
        return Payment::with([
            'negotiation'
        ])->find($id);
    }

    public function findByProviderPaymentId(string $providerPaymentId): ?Payment {
        return Payment::where(
            'provider_payment_id',
            $providerPaymentId
        )->first();
    }

    public function update(Payment $payment, array $data): bool {
        return $payment->update($data);
    }
}