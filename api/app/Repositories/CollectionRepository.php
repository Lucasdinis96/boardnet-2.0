<?php

namespace App\Repositories;

use App\Models\Collection;

class CollectionRepository {

    public function getUserCollection($id, $perPage = 6) {
        return Collection::where('user_id', $id)->paginate($perPage);
    }

    public function addToCollection($user, int $boardgameId) {
        return Collection::create([
            'user_id' => $user,
            'boardgame_id' => $boardgameId,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function removeBoardgame($user, int $boardgame) {
        return Collection::where('user_id', $user)->where('boardgame_id', $boardgame)->first()->delete();
    }

    public function checkCollection(int $user, int $boardgame) {
        return Collection::where('user_id', $user)->where('boardgame_id', $boardgame)->first();
    }

    public function removeFromCollection(int $id) {
        return Collection::where('id', $id)->first()->delete();
    }
}
