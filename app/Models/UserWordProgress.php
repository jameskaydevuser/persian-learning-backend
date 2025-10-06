<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserWordProgress extends Model
{
    protected $table = 'user_word_progress';

    protected $fillable = [
        'user_id',
        'word_id',
        'easy_completed',
        'normal_completed',
        'hard_completed',
        'easy_completed_at',
        'normal_completed_at',
        'hard_completed_at'
    ];

    protected $casts = [
        'easy_completed' => 'boolean',
        'normal_completed' => 'boolean',
        'hard_completed' => 'boolean',
        'easy_completed_at' => 'datetime',
        'normal_completed_at' => 'datetime',
        'hard_completed_at' => 'datetime'
    ];

    /**
     * Get the user that owns the progress record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the word for this progress record.
     */
    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class);
    }
}
