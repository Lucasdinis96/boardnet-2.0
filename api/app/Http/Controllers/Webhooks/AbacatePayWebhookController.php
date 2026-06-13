<?php

namespace App\Http\Controllers\Webhooks;

use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AbacatePayWebhookController extends Controller {

    public function __construct(
        private PaymentService $paymentService,
    ) {}

    public function handle(Request $request) {

        $webhookSecret = data_get($request->all(),'webhookSecret');

        if ($webhookSecret !== config('services.abacatepay.webhook_secret')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $payload = $request->all();

        $providerPaymentId = data_get($payload, 'data.checkout.id');

        if (!$providerPaymentId) {
            return response()->json([
                'success' => false,
                'message' => 'Pagamento inválido'
            ], 400);
        }

        $payment = Payment::query()->where('provider_payment_id',$providerPaymentId)->first();

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Pagamento não encontrado'
            ], 404);
        }

        $providerStatus = data_get($payload, 'data.checkout.status');

        if (in_array($providerStatus,['PAID', 'APPROVED'])) {

            if ($payment->status === PaymentStatus::Paid) {

                return response()->json(['data' => [
                    'success' => true,
                    'message' => 'Pagamento já processado'
                ]]);
            }
            
            $this->paymentService->markAsPaid(payment: $payment,providerResponse: $payload);
        }
        return response()->json(['data' => [
            'message' => 'Pagamento Realizado',
            'success' => true
        ]]);
    }
}