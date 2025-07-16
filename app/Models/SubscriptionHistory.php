<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionHistory extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $table = 'subscription_history';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
