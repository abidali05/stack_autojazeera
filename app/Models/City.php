<?php

namespace App\Models;

use App\Models\Bike\BikeLocation;
use App\Models\Bike\BikePost;
use Illuminate\Database\Eloquent\Model;
use GPBMetadata\Google\Cloud\Location\Locations;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('name', 'asc');
        });
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city');
    }

    protected $appends = ['count', 'bike_count'];
    public function getCountAttribute()
    {
        return location::where('city', $this->id)->count();
    }
    public function getBikeCountAttribute()
    {
        // return BikeLocation::where('city',$this->id)->count();
        $bikes =  BikeLocation::where('city', $this->id)->pluck('ad_id')->toArray();
        return BikePost::whereIn('id', $bikes)->where('status', '1')->whereNull('deleted_at')->count();
    }
}
