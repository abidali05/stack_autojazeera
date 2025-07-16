<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MakeCompany extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function posts() {
        return $this->hasMany(Post::class, 'make', 'id');
    }

    public function model()
    {
        return $this->hasMany(ModelCompany::class,'make_id','id');
    }

    //protected $appends = ['count'];

    //public function getCountAttribute()
    //{
     //   return $this->posts()->where('status', 1)->whereNull('deleted_at')->count();
    //}
	protected $appends = ['count'];

    public function getCountAttribute()
    {
		
        $query = DB::table('posts')
            ->where('posts.make', (string) $this->id)
            ->where('posts.status', 1)
            ->whereNull('posts.deleted_at');
//dd($query);
        // Check URL for 'used', 'new', or 'search'
        $path = request()->path();
        if (str_contains($path, 'cars/used')) {
        $query->where('posts.condition', 'used');
    } 
    // Check for 'new' conditions
    elseif (str_contains($path, 'cars/new')) {
        $query->where('posts.condition', 'new');
    }
        // 'search' shows all by default

        return $query->count();
    }
}
