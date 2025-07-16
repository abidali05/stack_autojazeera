<?php

namespace App\Models\Bike;

use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeLocation extends Model
{
    use HasFactory;

    protected $table = 'bike_location';
    protected $guarded = [];
    

    protected $appends = ['cityname','provincename'];
        
        public function getcityNameAttribute(){
            $city = City::find($this->city);
            return $city->name;
        }
        public function getprovinceNameAttribute(){
            $province = Province::find($this->province);
            return $province->name;
        }
}
