<?php

namespace App\Services;

use App\Http\Resources\Trade\TradeGetResource;
use App\Repositories\TradeRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TradeService {
    
    protected $tradeRepository;

    public function __construct(TradeRepository $tradeRepository) {
        $this->tradeRepository = $tradeRepository;
    }

    public function listTrades() {
        return $this->tradeRepository->getLatestTrades();
    }

    public function showTrade($id) {
        return TradeGetResource::make($this->tradeRepository->getUserTradeById($id));
    }

    public function createTrade(array $data) {
        return $this->tradeRepository->create($data, $data['boardgames']);
    }

    public function updateTrade($data, $trade) {

        $tradeData = [
            'id' => $data['id'],
            'title' => $data['title'] ?? null,
            'description' => $data['description'] ?? null,
        ];

        $boardgamesData = $data['boardgames'] ?? [];

        $trades = $this->tradeRepository->update($tradeData, $boardgamesData, $trade);

        return $trades;
    }

    public function deleteTrade($trade) {
        $this->tradeRepository->delete($trade);
    }

    public function getUserTrades(int $id) {
        return TradeGetResource::collection($this->tradeRepository->getAllUserTrades($id));
    }
}