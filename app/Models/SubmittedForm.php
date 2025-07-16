<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubmittedForm extends Model
{
    use HasFactory;
    public function post()
    {
        return $this->belongsTo(Post::class,'post_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'province', 'id');
    }
    
    public function city()
    {
        return $this->belongsTo(City::class, 'city', 'id');
    }
    public function location()
    {
        return $this->hasOne(location::class,'post_id','post_id');
    }
    public function contact()
    {
        return $this->hasOne(ContactInfo::class,'post_id','post_id');
    }
    public function document()
    {
        return $this->hasMany(Document::class,'post_id','post_id');
    }
    public function feature()
    {
        return $this->hasMany(Feature::class,'post_id','post_id');
    }
}
