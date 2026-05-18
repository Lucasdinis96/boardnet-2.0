<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Services\Cart\CartService;
use Illuminate\Http\Request;

class CartController extends Controller {

    public function __construct(
        private CartService $cartService
    ) {}

    public function show(Request $request) {

        return response()->json(
            $this->cartService->getCart($request->user())
        );
    }

    public function addItem(Request $request) {

        $request->validate([
            'trade_item_id' => ['required', 'integer', 'exists:trade_items,id']
        ]);

        $cart = $this->cartService->addItem(
            $request->user(),
            $request->trade_item_id
        );

        return response()->json($cart);
    }

    public function removeItem(Request $request, int $tradeItem) {

        $cart = $this->cartService->removeItem(
            $request->user(),
            $tradeItem
        );

        return response()->json($cart);
    }

    public function clear(Request $request) {

        $this->cartService->clear(
            $request->user()
        );

        return response()->json([
            'message' => 'Carrinho limpo com sucesso'
        ]);
    }
}