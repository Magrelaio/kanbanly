<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $boards = Auth::user()->boards()->with('columns.tasks.user')->get();
        
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
        $board = Auth::user()->boards()->create([
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