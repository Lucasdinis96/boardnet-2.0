<?php

namespace App\Repositories;

use App\Models\Boardgame;
use Illuminate\Support\Facades\Log;

class BoardgameRepository {
    
    public function getIndexPage() {
        return Boardgame::orderBy('release_date', 'desc')->get();
    }

    public function getHomePage(int $limit = 4): Boardgame {
        return Boardgame::limit($limit)->get();
    }

    public function find(int $id): Boardgame {
        return Boardgame::findOrFail($id);
    }

    public function search(string $term) {
        return Boardgame::where('title', 'like', "%{$term}%")
            ->orderBy('title')
            ->get();
    }

    public function filterGame(array $request) {
        $query = Boardgame::orderBy('release_date', 'desc');

        if (isset($request['game_name'])) {
            $query->where('title', 'like', "%{$request['game_name']}%");
        };

        if (isset($request['min_players']) && $request['min_players'] !== 0) {
            $query->where('min_players', '>=', "{$request['min_players']}");
        };

        if (isset($request['max_players']) && $request['max_players'] !== 0) {
            $query->where('max_players', '<=', "{$request['max_players']}");
        };

        if(isset($request['age_range']) && $request['age_range'] !== 0) {
            $query->where('age_range', '>=', $request['age_range']);
        };

        return $query->get();
    }
}