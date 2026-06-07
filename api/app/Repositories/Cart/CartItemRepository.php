<?php

namespace App\Repositories\Cart;

use App\Models\CartItem;
use Illuminate\Support\Facades\Log;

class CartItemRepository {

    public function exists(int $cartId, int $tradeItemId): bool {
        return CartItem::where([
            'cart_id' => $cartId,
            'trade_item_id' => $tradeItemId
        ])->exists();
    }

    public function create(array $data): CartItem {
        return CartItem::create($data);
    }

    public function remove(int $cartId, int $tradeItemId): void {
        CartItem::where([
            'cart_id' => $cartId,
            'trade_item_id' => $tradeItemId
        ])->delete();
    }

    public function clear(int $cartId): void {
        CartItem::where(
            'cart_id',
            $cartId
        )->delete();
    }
}