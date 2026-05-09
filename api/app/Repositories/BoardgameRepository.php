<?php

namespace App\Repositories;

use App\Models\Boardgame;

class BoardgameRepository {
    
    public function getIndexPage() {
        return Boardgame::all();
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
}