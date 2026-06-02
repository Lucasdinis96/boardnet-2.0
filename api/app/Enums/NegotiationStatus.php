<?php

namespace App\Enums;

enum NegotiationStatus: string {

    case PendingPayment = 'pending_payment';
    case Paid = 'paid';
    case Shipped = 'shipped';
    case Delivered = 'delivered';
    case Completed = 'completed';
    case Canceled = 'canceled';
    case Refunded = 'refunded';
    case Disputed = 'disputed';

    public function label(): string {

        return match($this) {

            self::PendingPayment => 'Aguardando Pagamento',
            self::Paid => 'Pago',
            self::Shipped => 'Enviado',
            self::Delivered => 'Entregue',
            self::Completed => 'Negociação Completa',
            self::Canceled => 'Cancelada',
            self::Refunded => 'Retornado',
            self::Disputed => 'Disputado'
        };
    }
}