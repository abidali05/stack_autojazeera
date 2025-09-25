<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ForumThread extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'user_id', 'title', 'is_pinned', 'is_locked', 'likes_count', 'views_count'];

    protected $casts = [
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(ForumCategory::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->hasMany(ForumPost::class, 'thread_id');
    }

    public function latestPost()
    {
        return $this->hasOne(ForumPost::class, 'thread_id')->latest();
    }

    public function likes()
    {
        return $this->morphMany(ForumLike::class, 'likeable');
    }

    public function favorites()
    {
        return $this->hasMany(ForumFavorite::class, 'thread_id');
    }

    public function isLikedBy($user = null)
    {
        $user = $user ?: Auth::user();
        return $user ? $this->likes()->where('user_id', $user->id)->exists() : false;
    }

    public function isFavoritedBy($user = null)
    {
        $user = $user ?: Auth::user();
        return $user ? $this->favorites()->where('user_id', $user->id)->exists() : false;
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }
}