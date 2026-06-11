<?php

namespace App\Services;

use App\Http\Requests\Trade\TradeUpdateRequest;
use App\Http\Resources\Trade\TradeDetailResource;
use App\Models\Trade;
use App\Repositories\TradeRepository;


class TradeService {
    
    protected $tradeRepository;

    public function __construct(TradeRepository $tradeRepository) {
        $this->tradeRepository = $tradeRepository;
    }

    public function listTrades(?array $filters = []) {
        return $this->tradeRepository->getLatestTrades($filters);
    }

    public function showTrade($id) {
        return TradeDetailResource::make($this->tradeRepository->getUserTradeById($id));
    }

    public function createTrade(array $data) {
        return $this->tradeRepository->create($data, $data['boardgames']);
    }

    public function updateTrade(array $data, Trade $trade) {
        $tradeData = [
            'id' => $trade->id,
            'title' => $data['title'] ?? null,
            'description' => $data['description'] ?? null,
            'images' => $data['images'] ?? [],
            'remaining_images' => $data['remaining_images'] ?? [],
            'primary_image_id' => $data['primary_image_id'] ?? null
        ];

        $boardgamesData = $data['boardgames'] ?? [];

        $trades = $this->tradeRepository->update($tradeData, $boardgamesData, $trade,);

        return $trades;
    }

    public function deleteTrade($trade) {
        $this->tradeRepository->delete($trade);
    }

    public function getUserTrades(int $id) {
        return TradeDetailResource::collection($this->tradeRepository->getAllUserTrades($id));
    }

    public function getTradeByBoardgame(int $id) {
        return $this->tradeRepository->getTradeByBoardgame($id);
    }
}