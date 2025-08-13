<?php

namespace App\Models;

use App\Enums\Task\TaskPriority;
use App\Enums\Task\TaskStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Policies\TaskPolicy;

class Task extends Model
{
    protected $fillable = [
        'id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'user_id',
    ];


    protected function casts()
    {

        return [
            'status' => TaskStatus::class,
            'priority' => TaskPriority::class,
            'due_date' => 'datetime'
        ];
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function scopeFilter($query)
    {
        if (request()->filled('status')) {
            $query->where('status', request('status'));
        }
        if (request()->filled('priority')) {
            $query->where('priority', request('priority'));
        }
        if (request()->filled('due_date')) {
            $query->where('due_date', request('due_date'));
        }
        if (request()->filled('user')) {
            $query->whereHas('user', function ($query) {
                $query->whereIn('name', request('user'));
            });
        }
        return $query;
    }
}
