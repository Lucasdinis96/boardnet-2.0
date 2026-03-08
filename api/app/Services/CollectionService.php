<?php

namespace App\Services;

use App\Repositories\CollectionRepository;
use App\Models\User;

class CollectionService {
    protected $repository;

    public function __construct(CollectionRepository $repository) {
        $this->repository = $repository;
    }

    public function getUserCollection(User $user) {
        return $this->repository->getUserCollection($user);
    }

    public function addBoardgame(User $user, int $boardgameId) {
        $this->repository->addToCollection($user, $boardgameId);
        return ['status' => 'added'];
    }

    public function removeBoardgame(User $user, int $boardgameId) {
        $this->repository->removeFromCollection($user, $boardgameId);
        return ['status' => 'removed'];
    }
}
