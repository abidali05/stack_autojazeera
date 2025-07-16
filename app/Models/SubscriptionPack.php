<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPack extends Model
{
    use HasFactory;
    protected $guarded=[];
    // protected $appends=['packagename'];
    // public function getpackagenameAttribute()
    // {
    //       $sub=SubscriptionPack::find($this->current_subscription);
    //   return $sub->name;
    // }
}
