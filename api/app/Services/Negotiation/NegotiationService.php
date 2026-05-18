<?php

namespace App\Services\Negotiation;

use App\Models\User;

use App\Repositories\Negotiation\NegotiationRepository;

use Exception;

class NegotiationService {

    public function __construct(
        private NegotiationRepository $negotiationRepository
    ) {}

    /*
    |--------------------------------------------------------------------------
    | Lista negociações
    |--------------------------------------------------------------------------
    */

    public function getUserNegotiations(
        User $user
    ) {

        return $this->negotiationRepository
            ->getUserNegotiations($user);
    }

    /*
    |--------------------------------------------------------------------------
    | Busca negociação
    |--------------------------------------------------------------------------
    */

    public function getNegotiation(
        User $user,
        int $negotiationId
    ) {

        $negotiation = $this->negotiationRepository
            ->findById($negotiationId);

        if (!$negotiation) {

            throw new Exception(
                'Negociação não encontrada'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Segurança
        |--------------------------------------------------------------------------
        */

        if (
            $negotiation->buyer_id !== $user->id &&
            $negotiation->seller_id !== $user->id
        ) {

            throw new Exception(
                'Negociação não encontrada'
            );
        }

        return $negotiation;
    }
}