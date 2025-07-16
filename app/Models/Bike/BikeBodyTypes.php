<?php

namespace App\Models\Bike;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BikeBodyTypes extends Model
{
    use HasFactory;
     protected $appends = ['count'];

    public function getIconAttribute($value)
    {
        return asset('posts/bodytypes/bikes/' . $value);
    }

    public function getCountAttribute()
    {
       // return $this->posts()->where('status', 1)->count();
		$query = DB::table('bikes_posts')
            ->where('bikes_posts.body_type', $this->id)
            ->where('bikes_posts.status', 1)
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
