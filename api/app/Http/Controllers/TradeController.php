<?php

namespace App\Http\Controllers;

use App\Http\Resources\Trade\TradeGetResource;
use App\Models\Trade;
use App\Services\TradeService;
use App\Support\PaginatedResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class TradeController extends Controller {
    
    protected $tradeService;

    use ApiResponse;

    public function __construct(TradeService $tradeService) {
        $this->tradeService = $tradeService;
    }

    public function index(Request $request) {
        $trades = $this->tradeService->listTrades($request->all());
        $response = PaginatedResource::make($trades, TradeGetResource::class);
        return $this->successResponse(
            $response,
            'Anúncios carregados com sucesso.'
        );
    }

    public function show(Request $request, int $id) {
        $trade = $this->tradeService->showTrade($id);
        return response()->json([
            'data' => $trade
        ]);
    }
}
