<?php

namespace App\Services\Cart;

use App\Models\User;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Cart\CartItemRepository;
use App\Models\TradeItem;
use App\Enums\TradeItemStatus;
use Exception;

class CartService {

    public function __construct(
        private CartRepository $cartRepository,
        private CartItemRepository $cartItemRepository
    ) {}

    public function getCart(User $user) {
        return $this->cartRepository ->getUserCart($user);
    }

    public function addItem(User $user, int $tradeItemId) {

        $tradeItem = TradeItem::findOrFail($tradeItemId);

        if ($tradeItem->trade->user_id === $user->id) {
            throw new Exception('Você não pode comprar seu próprio item');
        }

        if ($tradeItem->status !== TradeItemStatus::Available) {
            throw new Exception('Item indisponível');
        }

        $cart = $this->cartRepository->getOrCreate($user);

        $exists = $this->cartItemRepository->exists($cart->id, $tradeItemId);

        if (!$exists) {
            $this->cartItemRepository->create([
                'cart_id' => $cart->id,
                'trade_item_id' => $tradeItemId
            ]);
        }

        return $this->cartRepository->getUserCart($user);
    }

    public function removeItem(User $user, int $tradeItemId) {
        $cart = $this->cartRepository->getOrCreate($user);
        $this->cartItemRepository->remove($cart->id, $tradeItemId);
        return $this->cartRepository->getUserCart($user);
    }

    public function clear(User $user): void {
        $cart = $this->cartRepository->getOrCreate($user);
        $this->cartItemRepository->clear($cart->id);
    }
}