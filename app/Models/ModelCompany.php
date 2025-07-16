<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelCompany extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function make()
    {
        return $this->hasOne(MakeCompany::class,'id','make_id');
    }
    public function body()
    {
        return $this->hasOne(BodyType::class,'id','bodytype');
    }

    public function posts() {
        return $this->hasMany(Post::class, 'model', 'id');
    }

    protected $appends = ['count'];

    public function getCountAttribute()
    {
        return $this->posts()->where('status', 1)->whereNull('deleted_at')->count();
    }
	/* public function getCountAttribute()
    {
        $query = DB::table('posts')
            ->where('posts.model', $this->id)
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
    } */
}
