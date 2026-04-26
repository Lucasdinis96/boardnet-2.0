<?php

namespace App\Http\Controllers;

use App\Services\BoardgameService;
use App\Services\CollectionService;
use Illuminate\Http\Request;

class BoardgameController extends Controller {
    
    protected $boardgameService;
    protected $collectionService;

    public function __construct(BoardgameService $boardgameService, CollectionService $collectionService) {
        $this->boardgameService = $boardgameService;
        $this->collectionService = $collectionService;
    }

    public function index() {
        $boardgames = $this->boardgameService->listBoardgames();
        return response()->json([
            'data' => $boardgames
        ], 200);
    }

    public function show(int $id) {
        $boardgame = $this->boardgameService->getBoardgame($id);

        return response()->json([
            'data' => $boardgame
        ]);
    }

    public function addCollection(Request $request) {
        $response = $this->collectionService->addBoardgame($request->user_id, $request->boardgame_id);

        return response()->json([
            'data' => [
                'message' => 'Jogo adicionado com sucesso.'
            ]
        ], 200);
    }

    public function removeCollection(Request $request) {
        $response = $this->collectionService->removeBoardgame($request->user_id, $request->boardgame_id);

        return response()->json([
            'data' => [
                'message' => 'Jogo removido com sucesso.'
            ]
        ], 200);
    }

    public function checkCollection(int $userId, int $boardgameId) {
        $check = $this->collectionService->checkCollection($userId, $boardgameId);
        if ($check){
            return response()->json(['data' => '1']);
        }
        return response()->json(['data' => '0']);
    }
}