<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Column;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'column_id' => 'required|exists:columns,id',
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'labels' => 'nullable|array'
        ]);

        $column = Column::with('board')->find($validated['column_id']);
        
        if ($column->board->user_id !== Auth::id()) {
            return response()->json(['error' => 'Ação não autorizada.'], 403);
        }

        $maxOrder = Task::where('column_id', $column->id)->max('order') ?? 0;
        
        $task = Task::create([
            'column_id' => $validated['column_id'],
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'due_date' => $validated['due_date'] ?? null,
            'labels' => $validated['labels'] ?? [],
            'order' => $maxOrder + 1
        ]);

        return response()->json($task->load('user'));
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id() && $task->column->board->user_id !== Auth::id()) {
            return response()->json(['error' => 'Ação não autorizada.'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'column_id' => 'sometimes|exists:columns,id',
            'labels' => 'nullable|array'
        ]);

        $task->update($validated);
        
        return response()->json($task->load('user'));
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'tasks' => 'required|array',
            'tasks.*.id' => 'required|exists:tasks,id',
            'tasks.*.column_id' => 'required|exists:columns,id',
            'tasks.*.order' => 'required|integer'
        ]);

        foreach ($request->tasks as $taskData) {
            $task = Task::find($taskData['id']);
            
            if ($task->user_id !== Auth::id() && $task->column->board->user_id !== Auth::id()) {
                continue;
            }
            
            $task->update([
                'column_id' => $taskData['column_id'],
                'order' => $taskData['order']
            ]);
        }

        return response()->json(['message' => 'Tarefas reordenadas com sucesso!']);
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id() && $task->column->board->user_id !== Auth::id()) {
            return response()->json(['error' => 'Ação não autorizada.'], 403);
        }
        
        $task->delete();
        
        return response()->json(['message' => 'Tarefa excluída com sucesso!']);
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $tasks = Task::whereHas('column.board', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->with(['column', 'user'])
            ->get();
            
        return response()->json($tasks);
    }
}