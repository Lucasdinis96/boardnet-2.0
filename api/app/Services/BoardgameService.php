<?php

namespace App\Services;

use App\Http\Resources\Boardgames\BoardgameDetailResource;
use App\Repositories\BoardgameRepository;
use Illuminate\Http\Request;

class BoardgameService {
    protected $repository;

    public function __construct(BoardgameRepository $repository) {
        $this->repository = $repository;
    }

    public function listBoardgames(?array $filters = []) {
        return $this->repository->getIndexPage($filters);
    }

    public function getBoardgame(int $id) {
        return BoardgameDetailResource::make($this->repository->find($id));
    }

    public function searchGames(Request $data) {
        $term = $data->name;
        $games = $this->repository->search($term);

        return $games->map(function ($game) {
            return [
                'id' => $game->id,
                'title' => "{$game->title}",
            ];
        });
    }

    public function filterGame(array $request) {
        return $this->repository->filterGame($request);
    }
}