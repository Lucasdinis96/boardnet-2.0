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

    public function getAllUserNegotiations(User $user, $perPage = 3) {

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
        ->paginate($perPage);
    }

    public function updateStatus(Negotiation $negotiation, NegotiationStatus $status): bool {
        return $negotiation->update([
            'status' => $status
        ]);
    }

    public function paid (Negotiation $id) {
        $id->update(['paid_at' => now()]);
        $this->updateStatus(negotiation: $id, status: NegotiationStatus::Paid);
        return true;
    }

    public function shipped(array $shippingInfo, Negotiation $id) {
        $id->update([
                'shipping_company' => $shippingInfo['shipping_company'],
                'tracking_code' => $shippingInfo['tracking_code'],
                'shipped_at' => now()
            ]);

        $this->updateStatus(
            negotiation: $id,
            status: NegotiationStatus::Shipped
        );

        return true;
    }

    public function delivered(Negotiation $id) {
        $id->update([
            'delivered_at' => now(),
            'completed_at' => now()
            ]);

        $this->updateStatus(
            negotiation: $id,
            status: NegotiationStatus::Delivered
        );

        return true;
    }

    public function getUserNegotiationsAsBuyer(User $user, $perPage = 3) {

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
            );
        })
        ->latest()
        ->paginate($perPage);
    }

    public function getUserNegotiationsAsSeller(User $user, $perPage = 3) {

        return Negotiation::with([
            'items.boardgame',
            'buyer',
            'seller',
            'payments'
        ])
        ->where(function ($query) use ($user) {

            $query->where(
                'seller_id',
                $user->id
            );
        })
        ->latest()
        ->paginate($perPage);
    }
}