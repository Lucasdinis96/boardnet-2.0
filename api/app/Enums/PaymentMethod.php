<?php

namespace App\Enums;

enum PaymentMethod: string {

    case Pix = 'PIX';
    case CreditCard = 'CARD';
}