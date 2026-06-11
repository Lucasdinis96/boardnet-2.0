<?php

namespace App\Services;

use App\Repositories\CollectionRepository;

class CollectionService {
    protected $repository;

    public function __construct(CollectionRepository $repository) {
        $this->repository = $repository;
    }

    public function getUserCollection(int $id) {
        return $this->repository->getUserCollection($id);
    }

    public function addBoardgame(int $userId, int $boardgameId) {
        return $this->repository->addToCollection($userId, $boardgameId);
    }

    public function removeBoardgame(int $userId, int $boardgameId) {
        return $this->repository->removeBoardgame($userId, $boardgameId);
    }

    public function checkCollection(int $userId, int $boardgameId) {
        return $this->repository->checkCollection($userId, $boardgameId);
    }

    public function removeFromCollection(int $id) {
        return $this->repository->removeFromCollection($id);
    }
}
