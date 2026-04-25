<?php

namespace App\Http\Controllers;

use App\Services\BoardgameService;
use App\Services\CollectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        ]);
    }

    public function show(Request $request, $id) {
        $boardgame = $this->boardgameService->getBoardgame($id);

        return response()->json([
            'data' => $boardgame
        ]);
    }

    public function addCollection(Request $request) {
        $response = $this->collectionService->addBoardgame($request->user_id, $request->boardgame_id);

        return response()->json([
            'data' => [
                'status' => 'success',
                'message' => 'Jogo adicionado com sucesso.'
            ]
        ]);
    }

    public function removeCollection(Request $request) {
        $response = $this->collectionService->removeBoardgame($request->user_id, $request->boardgame_id);

        return response()->json([
            'data' => [
                'status' => 'success',
                'message' => 'Jogo removido com sucesso.'
            ]
        ]);
    }

    public function checkCollection($userId, $boardgameId) {
        $check = $this->collectionService->checkCollection($userId, $boardgameId);
        if ($check){
            return response()->json(['data' => 'existe']);
        }
        return response()->json(['data' => 'não']);
    }
}