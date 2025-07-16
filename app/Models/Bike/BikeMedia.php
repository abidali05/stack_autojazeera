<?php

namespace App\Models\Bike;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeMedia extends Model
{
    use HasFactory;
    protected $table = 'bike_media';
    protected $guarded = [];
    

    public function getFilePathAttribute($value)
    {
        return url($value);
    }
}
