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
        $trades = $this->tradeService->getTradeByBoardgame($id);

        return response()->json([
            'data' => [
                'boardgame' => $boardgame,
                'trades' => BoardgameTradeResource::collection($trades)
            ]
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

    public function filter(Request $request) {

        $filters = [
            'game_name' => $request->input('game_name'),
            'min_players' => $request->integer('min_players'),
            'max_players' => $request->integer('max_players'),
            'age_range' => $request->integer('age_range')
        ];
        $boardgames = $this->boardgameService->filterGame($filters);

        return response()->json([
            'data' => BoardgameGetResource::collection($boardgames)
        ], 200);
        
    }
}