<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CartRepository {

    public function getOrCreate(User $user): Cart {

        return Cart::firstOrCreate([
            'user_id' => $user->id
        ]);
    }

    public function getUserCart(User $user) {
        $this->getOrCreate($user);

        $cart = Cart::with([
            'items.tradeItem.boardgame',
            'items.tradeItem.trade.user',
            'items.tradeItem.trade'
        ])->where('user_id', $user->id)->firstOrCreate();

        $subtotal = $cart->items->sum(
            fn($item) => $item->tradeItem->value
        );
        $shipping = $cart->items
        ->pluck('tradeItem.trade')
        ->unique('id')
        ->sum('shipping_fee');
        $total = $subtotal + $shipping;
        return [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total' => $total,
        ];
    }
}