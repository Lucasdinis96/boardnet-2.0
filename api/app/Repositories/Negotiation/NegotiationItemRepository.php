<?php

namespace App\Repositories\Negotiation;

use App\Models\NegotiationItem;

class NegotiationItemRepository {

    public function create(array $data): NegotiationItem {
        return NegotiationItem::create($data);
    }
}