<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Color extends Model
{
    use HasFactory;
    protected $guarded=[];

    protected $appends=['count', 'bike_count'];
    public function getCountAttribute()
    {
       // return Post::where('exterior_color',$this->id,)->where('status', 1)->count();

        $query = DB::table('posts')
            ->where('posts.exterior_color', $this->id)
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
	
	public function getBikeCountAttribute()
    {
       // return Post::where('exterior_color',$this->id,)->where('status', 1)->count();

        $query = DB::table('bikes_posts')
            ->where('bikes_posts.color', $this->id)
            ->where('bikes_posts.status', '1')
            ->whereNull('bikes_posts.deleted_at');

        // Check URL for 'used', 'new', or 'search'
        $path = request()->path();
        if (str_contains($path, 'bikes/used')) {
            $query->where('bikes_posts.condition', 'used');
        } elseif (str_contains($path, 'bikes/new')) {
            $query->where('bikes_posts.condition', 'new');
        }
        // 'search' shows all by default

        return $query->count();
    }
}
