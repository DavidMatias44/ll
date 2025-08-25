<?php

namespace App\Models;

use App\Enums\Tasks\Priority;
use App\Enums\Tasks\State;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeState($query, $state)
    {
        return $query->when(! is_null($state), fn ($q) => $q->where('state', $state));
    }

    public function scopePriority($query, $priority)
    {
        return $query->when(! is_null($priority), fn ($q) => $q->where('priority', $priority));
    }
}
