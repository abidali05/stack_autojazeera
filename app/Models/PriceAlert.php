<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceAlert extends Model
{
    use HasFactory;
    protected $guarded = [];
	
	public function post()
    {
        return $this->belongsTo(Post::class,'post_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    // public function dealer(){
    //     return $this->belongsTo(User::class, $this->post->dealer_id, 'id');
    // }
}
