<?php

namespace App\Models\AutoServices;

use App\Models\Shops;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopWishlist extends Model
{
    use HasFactory;
    protected $table = 'shop_wishlist';
    protected $guarded = [];


    public function shop()
    {
        return $this->belongsTo(Shops::class, 'shop_id');
    }
}
