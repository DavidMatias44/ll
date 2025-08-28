<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pomodoro extends Model
{
    protected $fillable = [
        'user_id',
        'task_id',
        'num_session',
        'time',
    ];

    protected $hidden = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
