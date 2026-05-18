<?php

namespace App\Repositories\Payment;

use App\Models\Payment;

class PaymentRepository {

    /*
    |--------------------------------------------------------------------------
    | Cria pagamento
    |--------------------------------------------------------------------------
    */

    public function create(
        array $data
    ): Payment {

        return Payment::create($data);
    }

    /*
    |--------------------------------------------------------------------------
    | Busca por ID
    |--------------------------------------------------------------------------
    */

    public function findById(
        int $id
    ): ?Payment {

        return Payment::with([
            'negotiation'
        ])->find($id);
    }

    /*
    |--------------------------------------------------------------------------
    | Busca por provider payment id
    |--------------------------------------------------------------------------
    */

    public function findByProviderPaymentId(
        string $providerPaymentId
    ): ?Payment {

        return Payment::where(
            'provider_payment_id',
            $providerPaymentId
        )->first();
    }

    /*
    |--------------------------------------------------------------------------
    | Atualiza pagamento
    |--------------------------------------------------------------------------
    */

    public function update(
        Payment $payment,
        array $data
    ): bool {

        return $payment->update($data);
    }
}