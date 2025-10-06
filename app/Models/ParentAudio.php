<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParentAudio extends Model
{
    protected $fillable = [
        'parent_id',
        'word_id',
        'difficulty',
        'audio_file_path',
        'audio_file_name',
        'duration_seconds'
    ];

    protected $casts = [
        'duration_seconds' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class);
    }
}
