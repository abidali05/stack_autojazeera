<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainFeature extends Model
{
    use HasFactory;


    protected $appends=['count'];
    public function getCountAttribute()
    {
        return Feature::where('post_id',$this->id)->count();
    }
}
