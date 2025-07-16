<?php

namespace App\Models\Bike;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikePriceAlert extends Model
{
    use HasFactory;

    protected $table = 'bike_price_alerts';

    protected $guarded = [];

    protected $appends = ['post'];

    public function getPostAttribute()
    {
        return BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->find($this->post_id);
    }

    	public function post()
    {
        return $this->belongsTo(BikePost::class,'post_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
