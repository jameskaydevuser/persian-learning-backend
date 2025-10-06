<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'persian_name',
        'description'
    ];

    /**
     * Get the words for this category.
     */
    public function words(): HasMany
    {
        return $this->hasMany(Word::class);
    }
}
