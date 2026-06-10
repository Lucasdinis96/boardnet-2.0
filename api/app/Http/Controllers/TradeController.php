<?php

namespace App\Http\Controllers;

use App\Http\Requests\Trade\TradeCreateRequest;
use App\Http\Requests\Trade\UpdateTradeRequest;
use App\Http\Resources\Trade\TradeGetResource;
use App\Models\Boardgame;
use App\Models\Trade;
use App\Services\TradeService;
use Illuminate\Http\Request;

class TradeController extends Controller {
    
    protected $tradeService;

    public function __construct(TradeService $tradeService) {
        $this->tradeService = $tradeService;
    }

    public function index() {
        $trades = $this->tradeService->listTrades();
        return response()->json([
            'data' => TradeGetResource::collection($trades)
        ]);
    }

    public function show(Request $request, int $id) {
        $trade = $this->tradeService->showTrade($id);
        return response()->json([
            'data' => $trade
        ]);
    }

    public function filters(Request $request) {
        $filters = [
            'game_name' => $request->input('game_name'),
            'min_value' => $request->integer('min_value'),
            'max_value' => $request->integer('max_value'),
            'seller' => $request->input('seller')
        ];
        $trades = $this->tradeService->filterTrades($filters);

        return response()->json([
            'data' => TradeGetResource::collection($trades)
        ], 200);
    }
}
