<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * RELACIONAMENTOS
     */
    public function boards()
    {
        return $this->hasMany(Board::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getIncompleteTasksCountAttribute()
    {
        return $this->tasks()
            ->whereHas('column', function($query) {
                $query->where('title', '!=', 'Concluído');
            })
            ->count();
    }
    public function ownsBoard(Board $board)
    {
        return $this->id === $board->user_id;
    }

    public function canViewBoard(Board $board)
    {
        return $this->id === $board->user_id;
    }

    public function canEditTask(Task $task)
    {
        return $this->id === $task->user_id || 
               $this->id === $task->column->board->user_id;
    }

    public function getStatsAttribute()
    {
        return [
            'total_boards' => $this->boards()->count(),
            'total_tasks' => $this->tasks()->count(),
            'completed_tasks' => $this->tasks()
                ->whereHas('column', function($q) {
                    $q->where('title', 'Concluído');
                })->count(),
            'pending_tasks' => $this->tasks()
                ->whereHas('column', function($q) {
                    $q->where('title', '!=', 'Concluído');
                })->count(),
        ];
    }
}