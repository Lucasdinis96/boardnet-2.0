<?php

namespace App\Http\Controllers;

use App\Http\Resources\Boardgames\BoardgameGetResource;
use App\Http\Resources\Boardgames\BoardgameTradeResource;
use App\Services\BoardgameService;
use App\Services\CollectionService;
use App\Services\TradeService;
use App\Support\PaginatedResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BoardgameController extends Controller {

    use ApiResponse;
    
    protected $boardgameService;
    protected $collectionService;
    protected $tradeService;

    public function __construct(BoardgameService $boardgameService, CollectionService $collectionService, TradeService $tradeService) {
        $this->boardgameService = $boardgameService;
        $this->collectionService = $collectionService;
        $this->tradeService = $tradeService;
    }

    public function index(Request $request) {
        $boardgames = $this->boardgameService->listBoardgames($request->all());
        $response = PaginatedResource::make($boardgames, BoardgameGetResource::class);
        return $this->successResponse(
            $response,
            'Jogos carregados com sucesso.'
        );
    }

    public function show(int $id) {
        $boardgame = $this->boardgameService->getBoardgame($id);
        $trades = PaginatedResource::make(
            $this->tradeService->getTradeByBoardgame($id),
            BoardgameTradeResource::class
        );
            return $this->successResponse([
            'boardgame' => $boardgame,
            'trades' => $trades
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

    public function search (Request $request) {
       $games = $this->boardgameService->searchGames($request);
        return response()->json([
            'data' => $games
        ], 200);
    }
}