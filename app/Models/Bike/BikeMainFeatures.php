<?php

namespace App\Models\Bike;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeMainFeatures extends Model
{
    use HasFactory;
    protected $table = 'bike_main_features';
    protected $guarded = [];


    public function getIconAttribute($value)
    {
        return asset('posts/features/bikes/' . $value);
    }

    
}
