<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class location extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $appends=['cityname','provincename'];
  
    public function getcitynameAttribute()
    {
          $city=City::find($this->city);
      return $city->name??"";
    }   

    public function getprovincenameAttribute()
    {
          $province=Province::find($this->province);
      return $province->name??"";
    }

    public function province()
{
    return $this->belongsTo(Province::class, 'province', 'id');
}

public function city()
{
    return $this->belongsTo(City::class, 'city', 'id');
}
}
