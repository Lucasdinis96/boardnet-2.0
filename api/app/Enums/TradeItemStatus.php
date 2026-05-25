<?php

namespace App\Enums;

enum TradeItemStatus: string {

    case Available = 'available';
    case Reserved = 'reserved';
    case Sold = 'sold';
    case Inactive = 'inactive';
}