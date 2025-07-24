<?php

namespace App\Models;

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

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
