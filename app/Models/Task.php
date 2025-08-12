<?php

namespace App\Models;

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


    // protected function casts()
    // {

    // // return [

    // //     'status' => //enum ,
    // //     'priority' => //enum,
    // //     'due_date' => 'datetime'

    // // ];
    // // }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    
}
