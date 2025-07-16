<?php

namespace App\Models\AutoServices;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceSubscriptions extends Model
{
    use HasFactory;

    protected $table = 'services_subscriptions';
    protected $guarded = [];
    public function plan()
    {
        return $this->belongsTo(ServiceSubscriptionPlans::class, 'plan_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
