<?php

namespace App\Models\AutoServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSubscriptionPlanFeatures extends Model
{
    use HasFactory;
    protected $table = 'services_subscription_plan_features';
    protected $guarded = [];
}
