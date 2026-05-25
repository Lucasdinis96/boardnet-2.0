<?php

namespace App\Services\Checkout;

use App\Enums\NegotiationEventType;
use App\Enums\NegotiationItemStatus;
use App\Enums\NegotiationStatus;
use App\Enums\TradeItemStatus;
use App\Models\Cart;
use App\Models\User;
use App\Repositories\Negotiation\NegotiationItemRepository;
use App\Repositories\Negotiation\NegotiationRepository;
use App\Repositories\Trade\TradeItemRepository;
use App\Services\Negotiation\NegotiationEventService;
use Exception;
use Illuminate\Support\Facades\DB;

class CheckoutService {

    public function __construct(
        private NegotiationRepository $negotiationRepository,
        private NegotiationItemRepository $negotiationItemRepository,
        private TradeItemRepository $tradeItemRepository,
        private NegotiationEventService $eventService
    ) {}

    public function checkout(User $user, array $shippingAddress) {

        return DB::transaction(function () use (
            $user,
            $shippingAddress
        ) {

            $cart = Cart::with([
                'items.tradeItem.boardgame',
                'items.tradeItem.trade'
            ])->where(
                'user_id',
                $user->id
            )->first();

            if (!$cart || $cart->items->isEmpty()) {

                throw new Exception(
                    'Carrinho vazio'
                );
            }

            $subtotal = 0;

            /*
            |--------------------------------------------------------------------------
            | Validação dos itens
            |--------------------------------------------------------------------------
            */

            foreach ($cart->items as $cartItem) {

                $tradeItem = $cartItem->tradeItem;

                if (
                    $tradeItem->status !==
                    TradeItemStatus::Available
                ) {

                    throw new Exception(
                        "Item indisponível"
                    );
                }

                if (
                    $tradeItem->trade->user_id ===
                    $user->id
                ) {

                    throw new Exception(
                        'Você não pode comprar seus próprios itens'
                    );
                }

                $subtotal += $tradeItem->value;
            }

            $firstTradeItem = $cart->items
                ->first()
                ->tradeItem;

            $sellerId = $firstTradeItem
                ->trade
                ->user_id;

            $negotiation = $this->negotiationRepository
                ->create([
                    'buyer_id' => $user->id,
                    'seller_id' => $sellerId,
                    'status' => NegotiationStatus::PendingPayment,
                    'subtotal' => $subtotal,
                    'shipping_cost' => 0,
                    'total' => $subtotal,
                    'shipping_address_snapshot' => $shippingAddress
                ]);

            $this->eventService->create(
                negotiation: $negotiation,
                event: NegotiationEventType::Created,
                user: $user,
                metadata: [
                    'subtotal' => $subtotal,
                    'items_count' => $cart->items->count()
                ]
            );

            foreach ($cart->items as $cartItem) {
                $tradeItem = $cartItem->tradeItem;
                $this->negotiationItemRepository
                    ->create([
                        'negotiation_id' => $negotiation->id,
                        'trade_item_id' => $tradeItem->id,
                        'boardgame_id' => $tradeItem->boardgame_id,
                        'price' => $tradeItem->value,
                        'status' => NegotiationItemStatus::Reserved,
                        'boardgame_snapshot' => [
                            'title' => $tradeItem->boardgame->title,
                            'cover' => $tradeItem->boardgame->cover,
                            'price' => $tradeItem->value,
                        ]
                    ]);

                $this->tradeItemRepository->reserve($tradeItem);
            }

            $this->eventService->create(
                negotiation: $negotiation,
                event: NegotiationEventType::Reserved,
                user: $user
            );
                        
            $cart->items()->delete();

            $this->eventService->create(
                negotiation: $negotiation,
                event: NegotiationEventType::PaymentPending,
                user: $user
            );

            return $this->negotiationRepository
                ->findById($negotiation->id);
        });
    }
}