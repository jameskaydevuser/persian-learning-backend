<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'role',
        'parent_id',
        'username',
        'birth_date',
        'avatar_color',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }

    /**
     * Get the user's word progress records.
     */
    public function wordProgress(): HasMany
    {
        return $this->hasMany(UserWordProgress::class);
    }

    /**
     * Get the parent of this user (if user is a child).
     */
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    /**
     * Get the children of this user (if user is a parent).
     */
    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }

    /**
     * Check if user is a parent.
     */
    public function isParent(): bool
    {
        return $this->role === 'parent';
    }

    /**
     * Check if user is a child.
     */
    public function isChild(): bool
    {
        return $this->role === 'child';
    }

    /**
     * Get the parent audio recordings created by this user.
     */
    public function parentAudio()
    {
        return $this->hasMany(ParentWordAudio::class, 'parent_id');
    }
}
