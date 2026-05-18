<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\User;

class CartRepository {

    public function getOrCreate(User $user): Cart {

        return Cart::firstOrCreate([
            'user_id' => $user->id
        ]);
    }

    public function getUserCart(User $user): Cart {

        return Cart::with([
            'items.tradeItem.boardgame'
        ])->firstOrCreate([
            'user_id' => $user->id
        ]);
    }
}