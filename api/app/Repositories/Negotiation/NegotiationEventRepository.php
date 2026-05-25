<?php

namespace App\Repositories\Negotiation;

use App\Models\NegotiationEvent;

class NegotiationEventRepository {

    public function create(array $data): NegotiationEvent {
        return NegotiationEvent::create($data);
    }
}