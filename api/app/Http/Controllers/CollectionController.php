<?php

namespace App\Http\Controllers;

use App\Services\CollectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller {
    protected $service;

    public function __construct(CollectionService $service) {
        $this->service = $service;
    }

    public function index() {
        $boardgames = $this->service->getUserCollection(Auth::user());
        return response()->json($boardgames);
    }

    public function add(Request $request) {
        $user = Auth::user();
        $response = $this->service->addBoardgame($user, $request->boardgame_id);

        return response()->json([
            'status' => 'success',
            'message' => 'Jogo adicionado com sucesso.'
        ]);
    }

    public function remove($boardgameId, Request $request) {
        $user = Auth::user();
        $response = $this->service->removeBoardgame($user, $boardgameId);

        return $request->expectsJson() ? response()->json($response) : back();
    }
}
