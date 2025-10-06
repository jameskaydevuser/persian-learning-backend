<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParentSentence extends Model
{
    protected $fillable = [
        'parent_id',
        'word_id',
        'difficulty',
        'custom_sentence',
    ];

    /**
     * Get the parent that owns the sentence.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    /**
     * Get the word that this sentence belongs to.
     */
    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class);
    }
}
