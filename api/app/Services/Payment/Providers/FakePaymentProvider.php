<?php

namespace App\Services\Payment\Providers;

use App\Models\Payment;

use App\Services\Payment\Contracts\PaymentProviderInterface;

class FakePaymentProvider implements PaymentProviderInterface {

    public function createPixPayment(
        Payment $payment
    ): array {

        return [

            'provider_payment_id' => fake()->uuid(),

            'transaction_id' => fake()->uuid(),

            'payment_url' => 'https://boardnet.test/payment',

            'expires_at' => now()->addMinutes(15),

            'pix_copy_paste' => '000201010212...',

            'pix_qrcode' => 'base64fakeqrcode'
        ];
    }

    public function createCreditCardPayment(
        Payment $payment
    ): array {

        return [

            'provider_payment_id' => fake()->uuid(),

            'transaction_id' => fake()->uuid(),

            'payment_url' => 'https://boardnet.test/card-payment',

            'expires_at' => now()->addMinutes(15),
        ];
    }

    public function getPaymentStatus(
        string $providerPaymentId
    ): array {

        return [
            'status' => 'pending'
        ];
    }

    public function cancelPayment(
        string $providerPaymentId
    ): bool {

        return true;
    }
}