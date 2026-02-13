<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $boards = $user->boards()->with('columns.tasks')->get();
        
        return response()->json($boards);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'color' => 'nullable|string|in:blue,green,red,yellow,purple,gray'
        ]);

        $user = Auth::user();
        
        $board = $user->boards()->create([
            'title' => $validated['title'],
            'color' => $validated['color'] ?? 'blue'
        ]);
        
        $board->columns()->createMany([
            ['title' => 'A Fazer', 'order' => 1],
            ['title' => 'Em Progresso', 'order' => 2],
            ['title' => 'Concluído', 'order' => 3],
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Board criado com sucesso!',
                'board' => $board->load('columns')
            ], 201);
        }

        return redirect()->route('dashboard')->with('success', 'Board criado com sucesso!');
    }

    public function show(Board $board)
    {
        $user = Auth::user();
        
        if (!$user->canViewBoard($board)) {
            abort(403, 'Você não tem permissão para ver este board.');
        }

        $board->load(['columns.tasks' => function($query) {
            $query->orderBy('order')->with('user');
        }]);

        return response()->json($board);
    }

    public function update(Request $request, Board $board)
    {
        $user = Auth::user();

        if (!$user->ownsBoard($board)) {
            abort(403, 'Apenas o dono do board pode editá-lo.');
        }
        
        $validated = $request->validate([
            'title' => 'sometimes|required|max:255',
            'color' => 'nullable|string|in:blue,green,red,yellow,purple,gray'
        ]);

        $board->update($validated);
        
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Board atualizado com sucesso!',
                'board' => $board
            ]);
        }
        
        return redirect()->route('dashboard')->with('success', 'Board atualizado com sucesso!');
    }

    public function destroy(Board $board)
    {
        $user = Auth::user();
        
        if (!$user->ownsBoard($board)) {
            abort(403, 'Apenas o dono do board pode excluí-lo.');
        }
        
        $board->delete();
        
        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Board excluído com sucesso!'
            ]);
        }
        
        return redirect()->route('dashboard')->with('success', 'Board excluído com sucesso!');
    }

    public function duplicate(Board $board)
    {
        $user = Auth::user();
        
        if (!$user->canViewBoard($board)) {
            abort(403);
        }

        $newBoard = $user->boards()->create([
            'title' => $board->title . ' (cópia)',
            'color' => $board->color
        ]);

        foreach ($board->columns as $column) {
            $newColumn = $newBoard->columns()->create([
                'title' => $column->title,
                'order' => $column->order
            ]);

            foreach ($column->tasks as $task) {
                $newColumn->tasks()->create([
                    'user_id' => $user->id,
                    'title' => $task->title,
                    'description' => $task->description,
                    'order' => $task->order,
                    'labels' => $task->labels
                ]);
            }
        }

        return response()->json([
            'message' => 'Board duplicado com sucesso!',
            'board' => $newBoard->load('columns.tasks')
        ]);
    }
}