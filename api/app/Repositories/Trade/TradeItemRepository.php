<?php

namespace App\Repositories\Trade;

use App\Models\TradeItem;

class TradeItemRepository {

    public function create(array $boardgame, int $trade) {
        return TradeItem::create([
                'trade_id' => $trade,
                'boardgame_id' => $boardgame['boardgame_id'],
                'value' => $boardgame['value'] ?? null,
            ]);
    }

    public function findById(int $id): ?TradeItem {
        return TradeItem::with([
            'boardgame',
            'trade'
        ])->find($id);
    }

    public function reserve(TradeItem $tradeItem): bool {
        return $tradeItem->update([
            'status' => 'reserved',
            'reserved_until' => now()->addMinutes(15)
        ]);
    }

    public function release(TradeItem $tradeItem): bool {
        return $tradeItem->update([
            'status' => 'available',
            'reserved_until' => null
        ]);
    }

    public function sold(TradeItem $tradeItem): bool {
        return $tradeItem->update([
            'status' => 'sold',
            'reserved_until' => null
        ]);
    }
}