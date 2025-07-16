<?php

namespace App\Models;

namespace App\Models;
use Stripe\Stripe;
use Stripe\Subscription;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stripe\Product;

class DeallerSubscription extends Model
{
    use HasFactory;
    protected $guarded=[];

    protected $appends=['packagename'];
    public function getpackagenameAttribute()
    {
          $sub=SubscriptionPack::find($this->current_subscription);
      return $sub->name??"";
    }
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
	  public function subscribe()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        // Fetch the subscription from Stripe
     
        if ($this->current_subscription) {
        return  Product::retrieve($this->current_subscription);
        }

        return null; // No Stripe subscription ID available
        //return $this->hasOne(SubscriptionPack::class,'id','current_subscription'); 
    }
}
