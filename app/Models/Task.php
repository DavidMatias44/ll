<?php

namespace App\Models;

use App\Enums\Priority;
use App\Enums\State;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'name',
        'description',
        'state',
        'priority',
        'expiration',
        'user_id',
    ];

    protected $hidden = [];
    
    protected $casts = [
        'priority' => Priority::class,
        'state' => State::class,
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
