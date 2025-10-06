<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Word extends Model
{
    protected $fillable = [
        'category_id',
        'english_word',
        'persian_word',
        'emoji',
        'audio_easy',
        'audio_normal',
        'audio_hard',
        'easy_text',
        'normal_text',
        'hard_text'
    ];

    /**
     * Get the category that owns the word.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the user progress records for this word.
     */
    public function userProgress(): HasMany
    {
        return $this->hasMany(UserWordProgress::class);
    }

    /**
     * Get the parent sentences for this word.
     */
    public function parentSentences(): HasMany
    {
        return $this->hasMany(ParentSentence::class);
    }

    /**
     * Get the parent sentences for this word (alias for frontend compatibility).
     */
    public function parent_sentences(): HasMany
    {
        return $this->hasMany(ParentSentence::class);
    }
}
