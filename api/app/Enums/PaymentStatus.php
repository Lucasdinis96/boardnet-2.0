<?php

namespace App\Enums;

enum PaymentStatus: string {

    case Pending = 'pending';
    case Processing = 'processing';
    case Paid = 'paid';
    case Failed = 'failed';
    case Expired = 'expired';
    case Refunded = 'refunded';
    case Canceled = 'canceled';

    public function label(): string {

        return match($this) {

            self::Pending => 'Aguardando Pagamento',
            self::Processing => 'Processando',
            self::Paid => 'Pago',
            self::Failed => 'Falhado',
            self::Expired => 'Expirado',
            self::Refunded => 'Devolvido',
            self::Canceled => 'Cancelada',
        };
    }
}