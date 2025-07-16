<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopReview extends Model
{
    use HasFactory;

    protected $table = 'shop_reviews';
    protected $guarded = [];
	
	protected $appends = ['user', 'images'];

    public function getUserAttribute(){
		
        return User::find($this->user_id);
    }

    public function review_images(){
        return $this->hasMany(ShopReviewImage::class, 'review_id', 'id');
    }

    public function shop(){
        return $this->belongsTo(Shops::class, 'shop_id', 'id');
    }

    public function getImagesAttribute(){
        return ShopReviewImage::where('review_id', $this->id)->get();
    }
}
