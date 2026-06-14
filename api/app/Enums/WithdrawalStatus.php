<?php

namespace App\Enums;

enum WithdrawalStatus: string
{
    case AVAILABLE = 'available';
    case REQUESTED = 'requested';
    case PAID = 'paid';
    case CANCELLED = 'cancelled';
}