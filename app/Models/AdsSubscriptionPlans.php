<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdsSubscriptionPlans extends Model
{
    use HasFactory;
    protected $table = 'ads_subscription_plans';
    protected $guarded = [];

    public function features()
    {
        return $this->hasMany(AdsSubscriptionPlansFeatures::class, 'plan_id', 'id');
    }
}
