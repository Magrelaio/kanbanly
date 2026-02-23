<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $boards = $user->boards ?? collect([]);
        
        if ($boards->isEmpty()) {
            $board = $this->createDefaultBoard();
            $boards = collect([$board]);
            
        }

        $currentBoardId = $request->get('board', $boards->first()->id);
        $currentBoard = $boards->firstWhere('id', $currentBoardId) ?? $boards->first();

        return view('dashboard', [
            'boards' => $boards,
            'currentBoard' => $currentBoard
        ]);
    }

    private function createDefaultBoard()
    {
        $user = Auth::user();
        $board = Board::create([
            'user_id' => $user->id,
            'title' => 'Meu Primeiro Board',
            'color' => 'blue'
        ]);

        $columns = [
            ['title' => 'A Fazer', 'order' => 1],
            ['title' => 'Em Progresso', 'order' => 2],
            ['title' => 'Concluído', 'order' => 3],
        ];

        foreach ($columns as $column) {
            $board->columns()->create($column);
        }

        return $board;
    }
}