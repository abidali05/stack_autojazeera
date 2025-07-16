<?php

namespace App\Models\Bike;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeFeature extends Model
{
    use HasFactory;

    protected $table = 'bike_features';
    protected $guarded = [];

        protected $appends = ['featurename','icon'];
        
        public function getfeatureNameAttribute(){
            $feature = BikeMainFeatures::find($this->bike_main_feature_id);
            return $feature->name;
        }

        public function geticonAttribute(){
            $feature = BikeMainFeatures::find($this->bike_main_feature_id);
            return $feature->icon;
        }   


    
}
