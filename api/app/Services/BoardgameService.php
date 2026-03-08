<?php

namespace App\Services;

use App\Repositories\BoardgameRepository;

class BoardgameService {
    protected $repository;

    public function __construct(BoardgameRepository $repository) {
        $this->repository = $repository;
    }

    public function listBoardgames() {
        return $this->repository->getIndexPage();
    }

    public function getBoardgame(int $id) {
        return $this->repository->find($id);
    }
}