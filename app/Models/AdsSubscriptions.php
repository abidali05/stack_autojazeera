<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsSubscriptions extends Model
{
    use HasFactory;

    protected $table = 'ads_subscriptions';
    protected $guarded = [];

    public function plan(){
        return $this->belongsTo(AdsSubscriptionPlans::class, 'plan_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
