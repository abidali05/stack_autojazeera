<?php

namespace App\Models\AutoServices;

use App\Models\User;
use App\Models\Shops;
use App\Models\BodyType;
use App\Models\MakeCompany;
use App\Models\ModelCompany;
use App\Models\Bike\BikeMake;
use App\Models\Bike\BikeModels;
use App\Models\Bike\BikeBodyTypes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bookings extends Model
{
    use HasFactory;
    protected $table = 'bookings';
    protected $guarded = [];


    public function shop()
    {
        return $this->belongsTo(Shops::class);
    }

    public function make_r()
    {
        return $this->type == 'car'
            ? $this->belongsTo(MakeCompany::class, 'make', 'id')
            : $this->belongsTo(BikeMake::class, 'make', 'id');
    }

    public function model_r()
    {
        return $this->type === 'car'
            ? $this->belongsTo(ModelCompany::class, 'model', 'id')
            : $this->belongsTo(BikeModels::class, 'model', 'id');
    }


    public function bodytype_r()
    {
        return $this->type === 'car'
            ? $this->belongsTo(BodyType::class, 'bodytype', 'id')
            : $this->belongsTo(BikeBodyTypes::class, 'bodytype', 'id');
    }


    public function booking_services(){
        return $this->hasMany(BookingServices::class, 'booking_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    
}
