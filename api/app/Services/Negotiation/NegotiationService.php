<?php

namespace App\Services\Negotiation;

use App\Enums\NegotiationEventType;
use App\Models\Negotiation;
use App\Models\User;
use App\Repositories\Negotiation\NegotiationRepository;
use Exception;
use Illuminate\Support\Facades\Log;

class NegotiationService {

    public function __construct(
        private NegotiationRepository $negotiationRepository,
        private NegotiationEventService $eventService,
        private WithdrawalService $withdrawalService
    ) {}

    public function getAllUserNegotiations(User $user) {

        return $this->negotiationRepository->getAllUserNegotiations($user);
    }

    public function getUserNegotiationsAsBuyer(User $user) {

        return $this->negotiationRepository->getUserNegotiationsAsBuyer($user);
    }

    public function getUserNegotiationsAsSeller(User $user) {

        return $this->negotiationRepository->getUserNegotiationsAsSeller($user);
    }

    public function getNegotiation(User $user, int $negotiationId) {

        $negotiation = $this->negotiationRepository->findById($negotiationId);

        if (!$negotiation) {
            throw new Exception('Negociação não encontrada');
        };

        if ($negotiation->buyer_id !== $user->id && $negotiation->seller_id !== $user->id) {
            throw new Exception('Negociação não encontrada');
        };

        return $negotiation;
    }

    public function shipped (array $shippingInfo, Negotiation $id) {
        $this->negotiationRepository->shipped($shippingInfo, $id);

        $this->eventService->create(
            negotiation: $id,
            event: NegotiationEventType::Shipped,
            metadata: [
                'date' => now(),
                'shipping_company' => $shippingInfo['shipping_company'],
                'tracking_code' => $shippingInfo['tracking_code'],
            ]
        );

        return true;
    }

    public function delivered (Negotiation $id) {
        $this->negotiationRepository->delivered($id);

        $this->eventService->create(
            negotiation: $id,
            event: NegotiationEventType::Delivered,
            metadata: [
                'date' => now(),
                'address' => $id->shipping_address_snapshot
            ]
        );

        $this->withdrawalService->createFromNegotiation($id);

        return true;
    }
}