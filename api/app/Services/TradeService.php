<?php

namespace App\Services;

use App\Repositories\TradeRepository;
use Illuminate\Support\Facades\Auth;

class TradeService {
    
    protected $tradeRepository;

    public function __construct(TradeRepository $tradeRepository) {
        $this->tradeRepository = $tradeRepository;
    }

    public function listTrades() {
        return $this->tradeRepository->getLatestTrades();
    }

    public function showTrade($id) {
        return $this->tradeRepository->findById($id);
    }

    public function createTrade(array $data) {
        return $this->tradeRepository->create($data, $data['boardgames']);
    }

    public function updateTrade($trade, array $data) {
        return $this->tradeRepository->update($trade, $data, $data['boardgames']);
    }

    public function deleteTrade($trade) {
        $this->tradeRepository->delete($trade);
    }

    public function getUserTrades() {
        return $this->tradeRepository->getUserTrades(Auth::id());
    }

    public function removeBoardgame($trade, $boardgame) {
        $this->tradeRepository->detachBoardgame($trade, $boardgame->id);
    }
}