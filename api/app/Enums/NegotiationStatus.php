<?php

namespace App\Enums;

enum NegotiationStatus: string {

    case PendingPayment = 'pending_payment';
    case Paid = 'paid';
    case WaitingShipping = 'waiting_shipping';
    case Shipped = 'shipped';
    case Delivered = 'delivered';
    case Completed = 'completed';
    case Canceled = 'canceled';
    case Refunded = 'refunded';
    case Disputed = 'disputed';
}