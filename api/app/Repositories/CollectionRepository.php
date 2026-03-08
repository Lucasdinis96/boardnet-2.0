<?php

namespace App\Repositories;

use App\Models\User;

class CollectionRepository {

    public function getUserCollection(User $user) {
        return $user->boardgames()->withPivot('id')->paginate(8);
    }

    public function addToCollection(User $user, int $boardgameId) {
        return $user->boardgames()->syncWithoutDetaching([$boardgameId]);
    }

    public function removeFromCollection(User $user, int $boardgameId) {
        return $user->boardgames()->detach($boardgameId);
    }
}
