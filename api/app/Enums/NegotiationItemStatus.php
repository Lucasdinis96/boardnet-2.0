<?php

namespace App\Enums;

enum NegotiationItemStatus: string {

    case Reserved = 'reserved';

    case Paid = 'paid';

    case Shipped = 'shipped';

    case Delivered = 'delivered';

    case Refunded = 'refunded';

    case Canceled = 'canceled';
}