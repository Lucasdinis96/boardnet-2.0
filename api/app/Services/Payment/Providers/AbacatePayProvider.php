<?php

namespace App\Services\Payment\Providers;

use App\Models\Payment;
use App\Services\Payment\Contracts\PaymentProviderInterface;
use Illuminate\Support\Facades\Http;

class AbacatePayProvider implements PaymentProviderInterface {

    protected string $baseUrl;

    protected string $apiKey;

    public function __construct() {
        $this->baseUrl = config('services.abacatepay.base_url');
        $this->apiKey = config('services.abacatepay.api_key');
    }

    protected function client() {
        return Http::withToken($this->apiKey)
            ->acceptJson()
            ->contentType('application/json');
    }
    
    private function createProduct(Payment $payment) {
        $payload = [
            "externalId" => "prod-".$payment->id." negotiation". $payment->negotiation_id,
            "name" => "Pagamento Negociação ID ".$payment->id,
            "price" => $payment->amount * 100,
            "currency" => "BRL"
        ];
        $response = $this->client()->post(
            $this->baseUrl . 'products/create',
            $payload
        );
        return $response;

    }

    public function createPixPayment(Payment $payment): array {
        
        $product = $this->createProduct($payment);
        $negotiation = $payment->negotiation;
        $buyer = $negotiation->buyer;
        $payload = [
            'items' => [
                ['id' => $product['data']['id'], 'quantity' => 1]
            ],
            'methods' => [$payment->payment_method->value]
        ];

        $response = $this->client()->post(
            $this->baseUrl . 'checkouts/create',
            $payload
        );

        if ($response->failed()) {
            throw new \Exception(
                'Erro ao criar PIX no AbacatePay'
            );
        }

        $data = $response->json();

        return [
            'provider_payment_id' => $data['data']['id'] ?? null,
            'transaction_id' => $data['data']['txId'] ?? null,
            'payment_url' => $data['data']['paymentLink'] ?? null,
            'expires_at' => now()->addSeconds($data['data']['expiresIn'] ?? 900),
            'pix_copy_paste' => $data['data']['brCode'] ?? null,
            'pix_qrcode' => $data['data']['brCodeBase64'] ?? null,
            'provider_response' => $data
        ];
    }

    public function createCreditCardPayment(Payment $payment): array {
        throw new \Exception(
            'Cartão ainda não implementado'
        );
    }

    public function getPaymentStatus(string $providerPaymentId): array {
        $response = $this->client()->get(
            $this->baseUrl .
            '/pixQrCode/check/' .
            $providerPaymentId
        );

        if ($response->failed()) {
            throw new \Exception(
                'Erro ao consultar pagamento'
            );
        }

        $data = $response->json();

        return [
            'status' => $data['data']['status'] ?? 'pending',
            'provider_response' => $data
        ];
    }

    public function cancelPayment(string $providerPaymentId): bool {

        $response = $this->client()->post(
            $this->baseUrl .
            '/pixQrCode/cancel/' .
            $providerPaymentId
        );

        return $response->successful();
    }
}