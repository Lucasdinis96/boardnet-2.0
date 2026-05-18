<?php

namespace App\Services\Negotiation;

use App\Models\Negotiation;
use App\Models\User;

use App\Enums\NegotiationEventType;

use App\Repositories\Negotiation\NegotiationEventRepository;

class NegotiationEventService {

    public function __construct(
        private NegotiationEventRepository $repository
    ) {}

    public function create(
        Negotiation $negotiation,
        NegotiationEventType $event,
        ?User $user = null,
        ?array $metadata = null
    ) {

        return $this->repository->create([

            'negotiation_id' => $negotiation->id,

            'event' => $event,

            'user_id' => $user?->id,

            'metadata' => $metadata
        ]);
    }
}