<?php

namespace App\Repositories\Trade;

use App\Models\TradeImage;
use Illuminate\Database\Eloquent\Collection;

class TradeImageRepository
{
    public function create(array $data): TradeImage
    {
        return TradeImage::create($data);
    }

    public function findByTradeId(int $tradeId): Collection
    {
        return TradeImage::where('trade_id', $tradeId)
            ->orderBy('order')
            ->get();
    }

    public function findById(int $id): ?TradeImage
    {
        return TradeImage::find($id);
    }

    public function findPrimaryImage(int $tradeId): ?TradeImage
    {
        return TradeImage::where('trade_id', $tradeId)
            ->where('is_primary', true)
            ->first();
    }

    public function delete(TradeImage $image): bool
    {
        return $image->delete();
    }

    public function removeAllFromTrade(int $tradeId): void
    {
        TradeImage::where('trade_id', $tradeId)->delete();
    }
}