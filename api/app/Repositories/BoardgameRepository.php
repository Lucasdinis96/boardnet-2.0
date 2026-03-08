<?php

namespace App\Repositories;

use App\Models\Boardgame;

class BoardgameRepository {
    
    public function getIndexPage() {
        return Boardgame::paginate(8);
    }

    public function getHomePage(int $limit = 4) {
        return Boardgame::limit($limit)->get();
    }

    public function find(int $id): Boardgame {
        return Boardgame::findOrFail($id);
    }
}