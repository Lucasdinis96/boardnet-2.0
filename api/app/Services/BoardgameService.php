<?php

namespace App\Services;

use App\Http\Resources\Boardgames\BoardgameDetailResource;
use App\Http\Resources\Boardgames\BoardgameGetResource;
use App\Repositories\BoardgameRepository;

class BoardgameService {
    protected $repository;

    public function __construct(BoardgameRepository $repository) {
        $this->repository = $repository;
    }

    public function listBoardgames() {
        return BoardgameGetResource::collection($this->repository->getIndexPage());
    }

    public function getBoardgame(int $id) {
        return BoardgameDetailResource::make($this->repository->find($id));
    }
}