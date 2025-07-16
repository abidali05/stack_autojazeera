<?php

namespace App\Models\Bike;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BikeLeads extends Model
{
    use HasFactory;

    protected $table = 'bike_leads';
    protected $guarded = [];

    protected $appends = ['user','post'];


    public function getUserAttribute()
    {
        return User::find($this->user_id);
    }

    public function getPostAttribute()
    {   
        return BikePost::with(['features', 'location', 'contacts', 'media', 'dealer'])->find($this->post_id);
    }
}
