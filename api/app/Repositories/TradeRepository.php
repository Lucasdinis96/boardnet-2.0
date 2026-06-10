<?php

namespace App\Repositories;

use App\Http\Requests\Trade\TradeCreateRequest;
use App\Models\Trade;
use App\Models\TradeItem;
use App\Repositories\Trade\TradeImageRepository;
use App\Repositories\Trade\TradeItemRepository;
use App\Services\Image\ImageUploadService;
use Illuminate\Support\Facades\Storage;

class TradeRepository {

    public function __construct(
        private TradeItemRepository $tradeItemRepository,
        private TradeImageRepository $tradeImageRepository,
        private ImageUploadService $imageUploadService
    ) {}
    
    public function getLatestTrades(?int $limit = null) {

        $query = Trade::with(['user', 'boardgames', 'images'])->orderBy('created_at', 'desc');

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    public function findById($id) {
        return Trade::findOrFail($id);
    }

    public function getAllUserTrades($userId) {
        return Trade::with(['boardgames', 'user.city', 'images'])
            ->where('user_id', $userId)
            ->get();
    }

     public function getUserTradeById($tradeId) {
        return Trade::with(['boardgames', 'user.city', 'images'])
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

        if (!empty($data['images'])) {

            foreach ($data['images'] as $index => $image) {

                $path = $this->imageUploadService->upload(
                    $image,
                    "trades/{$trade->id}",
                    'trade_'.($index+1)
                );

                $this->tradeImageRepository->create([
                    'trade_id' => $trade->id,
                    'path' => $path,
                    'is_primary' => $index === 0,
                    'order' => $index + 1,
                ]);
            }
        }

        $trade = Trade::with('images')->find($trade->id);

        return $trade;
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

        if (isset($tradeData['remaining_images'])) {
            $remainingIds = $tradeData['remaining_images'] ?? [];
            $imagesToDelete = $trade->images()->whereNotIn('id', $remainingIds)->get();
            foreach ($imagesToDelete as $image) {
                Storage::disk('public')->delete($image->path);
            }
            $trade->images()->whereNotIn('id', $remainingIds)->delete();
        }


        if (!empty($tradeData['images'])) {
            $currentOrder = $trade->images()->max('order') ?? 0;
            foreach ($tradeData['images'] as $index => $image) {
                $currentOrder++;
                $path = $this->imageUploadService->upload(
                    $image,
                    "trades/{$trade->id}",
                    'trade_' . sprintf('%02d', $index + 1)
                );
                $this->tradeImageRepository->create([
                    'trade_id' => $trade->id,
                    'path' => $path,
                    'is_primary' => false,
                    'order' => $index + 1,
                ]);
            }
        }
        $trade->images()->update(['is_primary' => false]);
        if (!empty($tradeData['primary_image_id'])) {
            $trade->images()->where('id', $tradeData['primary_image_id'])->update(['is_primary' => true]);
        }
               
        return $trade->load('boardgames', 'images');
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
        return Trade::with([
            'user',
            'boardgames',
            'tradeItem',
            'images'
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
