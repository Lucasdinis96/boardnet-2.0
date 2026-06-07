<?php

namespace App\Repositories;

use App\Models\Trade;
use App\Models\TradeItem;
use App\Repositories\Trade\TradeItemRepository;
use Illuminate\Support\Facades\Log;

class TradeRepository {

    public function __construct(
        private TradeItemRepository $tradeItemRepository
    ) {}
    
    public function getLatestTrades(?int $limit = null) {

        $query = Trade::with(['user', 'boardgames'])->orderBy('created_at', 'desc');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    public function findById($id) {
        return Trade::findOrFail($id);
    }

    public function getAllUserTrades($userId) {
        return Trade::with(['boardgames', 'user.city'])
            ->where('user_id', $userId)
            ->get();
    }

     public function getUserTradeById($tradeId) {
        return Trade::with(['boardgames', 'user.city'])
            ->where('id', $tradeId)    
            ->first();
    }

    public function create(array $data, array $boardgames) {
        $trade = Trade::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'user_id' => $data['user_id'],
        ]);

        if (!$trade) {
            return false;
        }

        foreach ($boardgames as $boardgame) {
            $this->tradeItemRepository->create($boardgame, $trade->id);
        }

        return true;
    }

    public function update(array $tradeData, array $boardgamesTrade, Trade $trade) {
      
        if (isset($tradeData['title']) || isset($tradeData['description'])) {
            $trade->update([
                'title' => $tradeData['title'] ?? $trade->title,
                'description' => $tradeData['description'] ?? $trade->description,
            ]);
        }

        if (!empty($boardgamesTrade)) {
            $syncData = [];

            foreach ($boardgamesTrade as $boardgame) {
                if (!empty($boardgame['boardgame_id'])) {
                    $syncData[$boardgame['boardgame_id']] = [
                        'value' => $boardgame['value'] ?? null
                    ];
                }
            }

            $trade->boardgames()->sync($syncData);
        };
               
        return $trade->load('boardgames');
    }

    public function delete($trade) {
        TradeItem::where('trade_id', $trade)->delete();
        Trade::where('id', $trade)->delete();
        return true;
    }

    public function getTradeByBoardgame(int $id) {
        return TradeItem::with('trade')->where('boardgame_id', $id)->get();
    }

    public function filterTrades(array $filters) {
        Log::info($filters);
        return Trade::with([
            'user',
            'boardgames',
            'tradeItem'
        ])
        ->when(
            !empty($filters['game_name']),
            function ($query) use ($filters) {
                $query->whereHas('boardgames', function ($q) use ($filters) {
                    $q->where(
                        'title',
                        'like',
                        "%{$filters['game_name']}%"
                    );
                });
            }
        )
        ->when(
            isset($filters['min_value']) && isset($filters['max_value']) && $filters['min_value'] !== 0 && $filters['max_value'] !== 0,
            function ($query) use ($filters) {
                $query->whereHas('tradeItem', function ($q) use ($filters) {
                    $q->whereBetween('value', [
                        $filters['min_value'],
                        $filters['max_value']
                    ]);
                });
            }
        )
        ->when(
            !empty($filters['seller']),
            function ($query) use ($filters) {
                $query->whereHas('user', function ($q) use ($filters) {
                    $q->where(
                        'name',
                        'like',
                        "%{$filters['seller']}%"
                    );
                });
            }
        )
        ->latest()
        ->get();
    }
}
