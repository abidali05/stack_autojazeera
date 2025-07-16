<?php

namespace App\Models\Bike;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeContact extends Model
{
    use HasFactory;
    protected $table = 'bike_contacts';
    protected $guarded = [];
}
