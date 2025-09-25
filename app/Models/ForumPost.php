<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ForumPost extends Model
{
    use HasFactory;

    protected $fillable = ['thread_id', 'user_id', 'parent_id', 'body', 'likes_count', 'views_count'];

    public function thread()
    {
        return $this->belongsTo(ForumThread::class, 'thread_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(ForumPost::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(ForumPost::class, 'parent_id');
    }

    public function likes()
    {
        return $this->morphMany(ForumLike::class, 'likeable');
    }

    public function isLikedBy($user = null)
    {
        $user = $user ?: Auth::user();
        return $user ? $this->likes()->where('user_id', $user->id)->exists() : false;
    }
}