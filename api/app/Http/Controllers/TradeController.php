<?php

namespace App\Http\Controllers;

use App\Http\Requests\Trade\CreateTradeRequest;
use App\Http\Requests\Trade\UpdateTradeRequest;
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
        return response()->json($trades);
    }

    public function show(Request $request, int $id) {
        
        $trade = $this->tradeService->showTrade($id);
        return response()->json($trade);
    }

    public function getBoardgames() {
        $boardgames = Boardgame::orderBy('title')->get();
        return response()->json($boardgames);
    }

    public function store(CreateTradeRequest $request) {
        $data = $this->tradeService->createTrade($request->validated());
        return response()->json($data);
    }

    public function edit(Trade $trade) {

        if ($trade->user_id !== auth()->id()) {
            abort(403, 'Você não tem permissão para editar esta troca.');
        }

        $boardgames = Boardgame::all();
        return view('trades.edit', compact('trade', 'boardgames'));
    }

    public function update(UpdateTradeRequest $request, Trade $trade) {
        $this->tradeService->updateTrade($trade, $request->validated());
        return redirect()->route('myTrades');
    }

    public function destroy(Trade $trade) {

        if ($trade->user_id !== auth()->id()) {
            abort(403, 'Você não tem permissão para editar esta troca.');
        }
        $this->tradeService->deleteTrade($trade);
        return response()->json([
            'status' => 'success',
            'message' => 'Anúncio deletado com sucesso.'
        ]);
    }

    public function myTrades() {
        $trades = $this->tradeService->getUserTrades();
        return response()->json($trades);
    }

    public function detachBoardgame(Trade $trade, Boardgame $boardgame) {
        $this->tradeService->removeBoardgame($trade, $boardgame);
        return back()->with('success', 'Jogo removido do anúncio.');
    }
}
