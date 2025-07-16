<?php

namespace App\Models;

use App\Models\AutoServices\ShopImages;
use Illuminate\Database\Eloquent\Model;
use App\Models\AutoServices\ShopTimings;
use App\Models\AutoServices\ShopServices;
use App\Models\AutoServices\ShopAmenities;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shops extends Model
{
    use HasFactory;
    protected $table = 'shops';
    protected $guarded = [];
    protected $appends = ['rating', 'total_ratings', 'reviews', 'is_top_rated', 'shareable_link', 'rating_distribution','dealer'];

    public function getDealerAttribute(){
        return User::find($this->dealer_id) ?? null;
    }
    public function getLogoAttribute($value)
    {
        return $value ? asset('storage/' . $value) : null;
    }

    public function shop_images()
    {
        return $this->hasMany(ShopImages::class, 'shop_id', 'id');
    }
    public function shop_services()
    {
        return $this->hasMany(ShopServices::class, 'shop_id', 'id');
    }
    public function shop_timings()
    {
        return $this->hasMany(ShopTimings::class, 'shop_id', 'id');
    }
    public function shop_amenities()
    {
        return $this->hasMany(ShopAmenities::class, 'shop_id', 'id');
    }
    public function dealer()
    {
        return $this->belongsTo(User::class, 'dealer_id', 'id');
    }
    public function getRatingAttribute()
    {
        $average = ShopReview::where('shop_id', $this->id)->avg('rating');
        return number_format($average ? round($average, 1) : 0, 1, '.', '');
    }


    public function getTotalRatingsAttribute()
    {
        return ShopReview::where('shop_id', $this->id)->count();
    }

    public function shop_reviews()
    {
        return $this->hasMany(ShopReview::class, 'shop_id', 'id');
    }

    public function city_r()
    {
        return $this->belongsTo(City::class, 'city', 'id');
    }
    public function province_r()
    {
        return $this->belongsTo(Province::class, 'province', 'id');
    }

    public function getReviewsAttribute()
    {
        return  Null;
    }

    public function getIsTopRatedAttribute()
    {
        $reviewsCount = $this->shop_reviews()->count();
        $averageRating = $this->shop_reviews()->avg('rating');

        $res = $reviewsCount >= 10 && $averageRating >= 4.5;
        return $res ? '1' : '0';
    }

    public function getShareableLinkAttribute()
    {
        return route('shopdetail', $this->id);
    }

    public function getRatingDistributionAttribute()
    {
        $ratings = $this->shop_reviews()->pluck('rating');
        $total = $ratings->count();
        $distribution = [];

        for ($i = 1; $i <= 5; $i++) {
            $count = $ratings->filter(fn($r) => $r == $i)->count();
            $distribution[$i] = $total > 0 ? $count / $total : 0;
        }

        return $distribution;
    }
}
