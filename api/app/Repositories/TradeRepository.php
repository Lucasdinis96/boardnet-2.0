<?php

namespace App\Repositories;

use App\Models\Trade;
use App\Models\TradeItens;
use Illuminate\Support\Facades\Auth;

class TradeRepository {
    
    public function getLatestTrades(int $limit = 8)
    {
        return Trade::with(['user', 'boardgames'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function findById($id) {
        return Trade::findOrFail($id);
    }

    public function create(array $data, array $boardgames) {
        $trade = Trade::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'user_id' => Auth::id(),
        ]);

        foreach ($boardgames as $boardgame) {
            TradeItens::create([
                'trade_id' => $trade->id,
                'boardgame_id' => $boardgame['id'],
                'value' => $boardgame['value'] ?? null,
            ]);
        }

        return $trade;
    }

    public function update(Trade $trade, array $data, array $boardgames) {
        
        if (isset($data['title']) || isset($data['description'])) {
            $trade->update([
                'title' => $data['title'] ?? $trade->title,
                'description' => $data['description'] ?? $trade->description,
            ]);
        }
        
        if (!empty($boardgames)) {
            $syncData = [];
        }

        foreach ($boardgames as $boardgame) {
            if (!empty($boardgame['id'])) {
                $syncData[$boardgame['id']] = ['value' => $boardgame['value'] ?? null];
            }
        }

        $trade->boardgames()->sync($syncData);

        return $trade->load('boardgames');
    }

    public function delete(Trade $trade) {
        $trade->delete();
    }

    public function getUserTrades($userId) {
        return Trade::with(['boardgames', 'user.city'])
            ->where('user_id', $userId)
            ->get();
    }

    public function detachBoardgame(Trade $trade, int $boardgameId) {
        
        if ($trade->user_id !== Auth::id()) {
            return response()->json(['message' => 'Você não tem permissão para deletar esta troca.'], 403);
        }
        $trade->boardgames()->detach($boardgameId);
    }
}
