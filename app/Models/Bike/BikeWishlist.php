<?php

namespace App\Models\Bike;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeWishlist extends Model
{
    use HasFactory;

    protected $table = 'bike_wishlist';

    protected $guarded = [];

    protected $appends = ['post'];

    public function getPostAttribute()
    {
        return BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->find($this->post_id);
    }
}
