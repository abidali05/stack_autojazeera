<?php

namespace App\Models\AutoServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSubscriptionPlans extends Model
{
    use HasFactory;
    protected $table = 'services_subscription_plans';
    protected $guarded = [];

    public function features(){
        return $this->hasMany(ServiceSubscriptionPlanFeatures::class, 'plan_id');
    }
}
