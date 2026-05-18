<?php

namespace App\Repositories\Negotiation;

use App\Models\Negotiation;
use App\Models\User;

class NegotiationRepository {

    /*
    |--------------------------------------------------------------------------
    | Cria negociação
    |--------------------------------------------------------------------------
    */

    public function create(array $data): Negotiation {

        return Negotiation::create($data);
    }

    /*
    |--------------------------------------------------------------------------
    | Busca negociação por ID
    |--------------------------------------------------------------------------
    */

    public function findById(int $id): ?Negotiation {

        return Negotiation::with([
            'items.boardgame',
            'buyer',
            'seller',
            'payments',
            'events'
        ])->find($id);
    }

    /*
    |--------------------------------------------------------------------------
    | Lista negociações do usuário
    |--------------------------------------------------------------------------
    */

    public function getUserNegotiations(
        User $user
    ) {

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
}