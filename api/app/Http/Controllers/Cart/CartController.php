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
        return response()->json(['data' => $this->cartService->getCart($request->user())]);
    }

    public function addItem(Request $request) {
        $request->validate(['trade_item_id' => ['required', 'integer', 'exists:trade_items,id']]);
        $cart = $this->cartService->addItem($request->user(), $request->trade_item_id);
        return response()->json(['data' => ['message' => 'Item adicionado ao carrinho.']]);
    }

    public function removeItem(Request $request, int $tradeItem) {
        $cart = $this->cartService->removeItem($request->user(),$tradeItem);
        return response()->json(['data' =>['message' => 'Item Removido do carrinho']]);
    }

    public function clear(Request $request) {
        $this->cartService->clear($request->user());
        return response()->json(['data' => ['message' => 'Carrinho limpo com sucesso']]);
    }
}