<?php

namespace App\Http\Controllers;

use App\Services\BoardgameService;
use Illuminate\Http\Request;

class BoardgameController extends Controller {
    
    protected $service;

    public function __construct(BoardgameService $service) {
        $this->service = $service;
    }

    public function index() {
        $boardgames = $this->service->listBoardgames();
        return response()->json($boardgames);
    }

    public function show(Request $request, int $id) {
        
        $boardgame = $this->service->getBoardgame($id);

        return response()->json($boardgame);
    }
}