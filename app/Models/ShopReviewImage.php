<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopReviewImage extends Model
{
    use HasFactory;

    protected $table = 'shop_review_images';
    protected $guarded = [];

    public function getPathAttribute($value)
    {
        return asset($value);
    }
    
}
