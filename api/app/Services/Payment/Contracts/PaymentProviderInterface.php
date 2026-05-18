<?php

namespace App\Services\Payment\Contracts;

use App\Models\Payment;

interface PaymentProviderInterface {

    /*
    |--------------------------------------------------------------------------
    | PIX
    |--------------------------------------------------------------------------
    */

    public function createPixPayment(
        Payment $payment
    ): array;

    /*
    |--------------------------------------------------------------------------
    | Crédito
    |--------------------------------------------------------------------------
    */

    public function createCreditCardPayment(
        Payment $payment,
        // array $cardData
    ): array;

    /*
    |--------------------------------------------------------------------------
    | Consulta pagamento
    |--------------------------------------------------------------------------
    */

    public function getPaymentStatus(
        string $providerPaymentId
    ): array;

    /*
    |--------------------------------------------------------------------------
    | Cancelamento
    |--------------------------------------------------------------------------
    */

    public function cancelPayment(
        string $providerPaymentId
    ): bool;
}