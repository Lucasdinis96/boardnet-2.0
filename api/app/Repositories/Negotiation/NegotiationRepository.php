<?php

namespace App\Repositories\Negotiation;

use App\Enums\NegotiationStatus;
use App\Models\Negotiation;
use App\Models\User;

class NegotiationRepository {

    public function create(array $data): Negotiation {
        return Negotiation::create($data);
    }

    public function findById(int $id): ?Negotiation {
        return Negotiation::with([
            'items.boardgame',
            'buyer',
            'seller',
            'payments',
            'events'
        ])->find($id);
    }

    public function getUserNegotiations(User $user) {

        return Negotiation::with([
            'items.boardgame',
            'buyer',
            'seller',
            'payments'
        ])
        ->where(function ($query) use ($user) {

            $query->where(
                'buyer_id',
                $user->id
            )->orWhere(
                'seller_id',
                $user->id
            );
        })
        ->latest()
        ->get();
    }

    public function updateStatus(Negotiation $negotiation, NegotiationStatus $status): bool {
        return $negotiation->update([
            'status' => $status
        ]);
    }

    public function shipped(string $trackingCode, Negotiation $id) {
        $id->update(['shipped_at' => now()]);

        $this->updateStatus(
            negotiation: $id,
            status: NegotiationStatus::Shipped
        );

        return true;
    }

    public function delivered(Negotiation $id) {
        $id->update(['delivered_at' => now()]);

        $this->updateStatus(
            negotiation: $id,
            status: NegotiationStatus::Delivered
        );

        return true;
    }
}