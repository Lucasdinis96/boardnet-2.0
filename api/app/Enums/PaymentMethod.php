<?php

namespace App\Enums;

enum PaymentMethod: string {

    case Pix = 'PIX';
    case CreditCard = 'CARD';

    public function label(): string {

        return match($this) {
            self::Pix => 'Pix',
            self::CreditCard => 'Cartão de Crédito'
        };
    }
}