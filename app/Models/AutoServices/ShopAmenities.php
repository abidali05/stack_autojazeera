<?php

namespace App\Models\AutoServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopAmenities extends Model
{
    use HasFactory;

    protected $table = 'shop_amenities';
    protected $guarded = [];
    public $appends = ['amenity_name'];


    public function amenity()
    {
        return $this->belongsTo(Amenities::class, 'amenity_id', 'id');
    }
   
    public function getAmenityNameAttribute()
    {
        return $this->amenity ? $this->amenity->name : null;
    }

}
