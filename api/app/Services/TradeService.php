<?php

namespace App\Services;

use App\Http\Resources\Trade\TradeDetailResource;
use App\Repositories\TradeRepository;


class TradeService {
    
    protected $tradeRepository;

    public function __construct(TradeRepository $tradeRepository) {
        $this->tradeRepository = $tradeRepository;
    }

    public function listTrades() {
        return $this->tradeRepository->getLatestTrades();
    }

    public function showTrade($id) {
        return TradeDetailResource::make($this->tradeRepository->getUserTradeById($id));
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
        return TradeDetailResource::collection($this->tradeRepository->getAllUserTrades($id));
    }
}