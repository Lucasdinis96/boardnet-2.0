<?php

namespace App\Services;

use App\Http\Resources\Collection\CollectionGetResource;
use App\Models\User;
use App\Repositories\CollectionRepository;
use Illuminate\Support\Facades\Log;

class CollectionService {
    protected $repository;

    public function __construct(CollectionRepository $repository) {
        $this->repository = $repository;
    }

    public function getUserCollection($id) {
        return CollectionGetResource::collection($this->repository->getUserCollection($id));
    }

    public function addBoardgame($userId, $boardgameId) {
        $this->repository->addToCollection($userId, $boardgameId);
        return ['status' => 'added'];
    }

    public function removeBoardgame($userId, int $boardgameId) {
        $this->repository->removeBoardgame($userId, $boardgameId);
        return ['status' => 'removed'];
    }

    public function checkCollection($userId, $boardgameId) {
        return $this->repository->checkCollection($userId, $boardgameId);
    }

    public function removeFromCollection($id) {
        $this->repository->removeFromCollection($id);
        return ['status' => 'removed'];
    }
}
