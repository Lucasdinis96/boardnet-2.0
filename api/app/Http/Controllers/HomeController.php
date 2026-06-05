<?php

namespace App\Http\Controllers;

use App\Http\Resources\Boardgames\BoardgameGetResource;
use App\Http\Resources\Trade\TradeGetResource;
use App\Models\Boardgame;
use App\Models\Trade;
use App\Services\TradeService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct (TradeService $tradeService) {
        $this->tradeService = $tradeService;
    }
    
    public function getHomeGames(int $limit = 4) {
        return response()->json([
            'data' => BoardgameGetResource::collection(Boardgame::limit($limit)->orderBy('created_at', 'desc')->get())
        ]);
    }

    public function getHomeTrades(int $limit = 4) {
        $trades = $trades = $this->tradeService->listTrades($limit);
        return response()->json([
            'data' => TradeGetResource::collection($trades)
        ]);
    }
}
