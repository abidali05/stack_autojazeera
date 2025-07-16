<?php

namespace App\Models\Bike;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BikeMake extends Model
{
    use HasFactory;

    protected $table = 'bike_makes';
    protected $guarded = [];
    protected $appends = ['count'];

    public function models()
    {
        return $this->hasMany(BikeModels::class, 'make_id', 'id');
    }

    public function getIconAttribute($value)
    {
        return asset('posts/makes/bikes/' . $value);
    }


    public function getCountAttribute()
    {

        $query = DB::table('bikes_posts')
            ->where('bikes_posts.make', (string) $this->id)
            ->where('bikes_posts.status', 1)
            ->whereNull('bikes_posts.deleted_at');
        $path = request()->path();
        if (str_contains($path, 'bikes/used')) {
            $query->where('bikes_posts.condition', 'used');
        }
        // Check for 'new' condition
        elseif (str_contains($path, 'bikes/new')) {
            $query->where('bikes_posts.condition', 'new');
        }

        return $query->count();
    }
}
