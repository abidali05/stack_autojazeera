<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BodyType extends Model
{
    use HasFactory;

    public function posts() {
        return $this->hasMany(Post::class, 'body_type', 'id');
    }
    protected $appends = ['count'];

    public function getCountAttribute()
    {
       // return $this->posts()->where('status', 1)->count();
		$query = DB::table('posts')
            ->where('posts.body_type', $this->id)
            ->where('posts.status', 1)
            ->whereNull('posts.deleted_at');

        // Check URL for 'used', 'new', or 'search'
        $path = request()->path();
        if (str_contains($path, 'cars/used')) {
            $query->where('posts.condition', 'used');
        } elseif (str_contains($path, 'cars/new')) {
            $query->where('posts.condition', 'new');
        }
        // 'search' shows all by default

        return $query->count();
    }
}
