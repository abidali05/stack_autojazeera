<?php

namespace App\Models\Bike;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeModels extends Model
{
    use HasFactory;
    protected $table = 'bike_models';
    protected $guarded = [];

    public function make()
    {
        return $this->hasOne(BikeMake::class,'id','make_id');
    }
    public function body()
    {
        return $this->hasOne(BikeBodyTypes::class,'id','bodytype');
    }

    protected $appends = ['count'];

    public function getCountAttribute()
    {
        return BikePost::where('model', $this->id)->where('status', 1)->whereNull('deleted_at')->count();
    }

    // public function bikes() {
    //     return $this->hasMany(Bikes::class, 'model', 'id');
    // }

    // protected $appends = ['count'];

    // public function getCountAttribute()
    // {
    //     return $this->posts()->where('status', 1)->whereNull('deleted_at')->count();
    // }
}
