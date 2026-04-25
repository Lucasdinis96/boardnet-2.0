<?php

namespace App\Repositories;

use App\Models\Collection;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CollectionRepository {

    public function getUserCollection($id) {
        $coll = Collection::where('user_id', $id)->get();
        return $coll;
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

    public function checkCollection($user, $boardgame) {
        return Collection::where('user_id', $user)->where('boardgame_id', $boardgame)->first();
    }

    public function removeFromCollection($id) {
        return Collection::where('id', $id)->first()->delete();
    }
}
