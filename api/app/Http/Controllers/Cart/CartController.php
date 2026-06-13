<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cart\CartGetResource;
use App\Services\Cart\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CartController extends Controller {

    public function __construct(
        private CartService $cartService
    ) {}

    public function show(Request $request) {
        Log::info('teste', [$request->user()]);
        $cart = $this->cartService->getCart($request->user());

        if (!$cart) {
            return response()->json(['data' =>['message' => 'Carrinho vazio!']]);
        }

        return response()->json(['data' => CartGetResource::make($cart)]);
    }

    public function addItem(Request $request) {
        $request->validate(['trade_item_id' => ['required', 'integer', 'exists:trade_items,id']]);
        $cart = $this->cartService->addItem($request->user(), $request->trade_item_id);
        return response()->json(['data' => ['message' => 'Item adicionado ao carrinho.']]);
    }

    public function removeItem(Request $request, int $tradeItem) {
        $cart = $this->cartService->removeItem($request->user(), $tradeItem);
        return response()->json(['data' =>['message' => 'Item Removido do carrinho.']]);
    }

    public function clear(Request $request) {
        $this->cartService->clear($request->user());
        return response()->json(['data' => ['message' => 'Carrinho limpo com sucesso.']]);
    }
}