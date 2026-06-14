<?php

namespace App\Repositories;

use App\Models\Boardgame;
use Illuminate\Support\Facades\Log;

class BoardgameRepository {
    
    public function getIndexPage(?array $filters = [], $perPage = 6) {
        $query = Boardgame::orderBy('release_date', 'desc');

        if (!empty($filters['game_name'])) {
            $query->where('title', 'like', "%{$filters['game_name']}%");
        };

        if (isset($filters['min_players']) && $filters['min_players'] !== 0) {
            $query->where('min_players', '>=', "{$filters['min_players']}");
        };

        if (isset($filters['max_players']) && $filters['max_players'] !== 0) {
            $query->where('max_players', '<=', "{$filters['max_players']}");
        };

        if(isset($filters['age_range']) && $filters['age_range'] !== 0) {
            $query->where('age_range', '>=', $filters['age_range']);
        };

        return $query->latest()->paginate($perPage);
    }

    public function find(int $id): Boardgame {
        return Boardgame::findOrFail($id);
    }

    public function search(string $term) {
        return Boardgame::where('title', 'like', "%{$term}%")
            ->orderBy('title')
            ->get();
    }
}