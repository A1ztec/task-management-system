<?php

namespace App\Models;

use App\Enums\task\TaskPriority;
use App\Enums\Task\TaskStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
