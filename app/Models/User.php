<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Stripe\Stripe;
use Stripe\Product;
use App\Models\Bike\BikePost;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Models\AutoServices\ServiceSubscriptionPlans;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    protected $fillable = [
        'name',
        'email',
        'password',
        'number',
        'otp',
        'status',
        'dealer_logo',
        'role',
        'dealershipName',
        'image',
        'userType',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'previous_price' => 'integer',
        'is_number_verified' => 'boolean',
        'is_email_verified' => 'boolean'
    ];

    protected $appends = ['cityname', 'packagename', 'permissions', 'feature_ad_count', 'total_ads_count', 'feature_ad_limit', 'shareable_link', 'service_package_name', 'shop_pkg', 'ads_pkg'];

    public function getShareableLinkAttribute()
    {
        return route('cardetail', ['id' => $this->id]);;
    }

    public function getpermissionsAttribute()
    {
        if ($this->role == 2) {
            $permissions = UserPermission::where('user_id', $this->id)->pluck('permissions');
            return $permissions;
        } else {
            return null;
        }
    }
    public function getcitynameAttribute()
    {
        if ($this->city !== null) {
            $city = City::find($this->city);

            // Check if the city exists to avoid trying to access a null object's property
            if ($city) {
                return $city->name;
            }
        }

        return null;
    }

    public function getpackagenameAttribute()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        if (!empty($this->package)) {
            try {
                $sub = Product::retrieve($this->package);
                return $sub?->name;
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }


    public function getfeatureAdCountAttribute()
    {
        if ($this->role == 2) {
            $car_ads =  Post::where('dealer_id', $this->dealer_id)->where('feature_ad', 1)->count();
            $bike_ads =  BikePost::where('dealer_id', $this->dealer_id)->where('is_featured', 1)->count();
            return $car_ads + $bike_ads;
        } else {
            $car_ads =  Post::where('dealer_id', $this->id)->where('feature_ad', 1)->count();
            $bike_ads =  BikePost::where('dealer_id', $this->id)->where('is_featured', 1)->count();
            return $car_ads + $bike_ads;
        }
    }

    public function getfeatureAdLimitAttribute()
    {
        return 35;
    }



    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasPermission($permissionName)
    {
        return $this->permissions()->where('name', $permissionName)->exists();
    }
    public function posts()
    {
        return $this->hasMany(Post::class, 'dealer_id'); // Assuming 'dealer_id' is the foreign key in posts table
    }

    protected static function boot()
    {
        parent::boot();

        // Automatically format the phone number before saving
        static::saving(function ($user) {
            $user->number = self::getPhone($user->number, '+92', false);
        });
    }


    private static function getPhone(?string $number, ?string $prefix = null, bool $mask = false): ?string
    {
        if ($number === null) {
            return null;
        }

        // Remove all + and - symbols
        $input = preg_replace('/[+\-]/', '', $number);
        $input = trim($input);

        // Remove extra spaces between digits
        $input = preg_replace('/\s+/', '', $input);

        // Remove the prefix 92, 920, or 0 if they appear at the start of the string
        $input = preg_replace('/^(92|920|0)/', '', $input);

        // Recursively remove first two digits if they are 92
        while (strpos($input, '92') === 0) {
            $input = preg_replace('/^92/', '', $input);
        }

        // Apply mask if needed
        if ($mask && strlen($input) > 3) {
            $input = substr($input, 0, 3) . '-' . substr($input, 3);
        }

        // Add prefix if provided
        if ($prefix !== null) {
            $input = $prefix . $input;
        }

        return $input;
    }
    // public function ads_package()
    // {
    //     Stripe::setApiKey(config('services.stripe.secret'));
    //     return $this->belongsTo(Product::class, 'package');
    // }
    // public function service_package()
    // {
    //     if ($this->shop_package) {
    //         Stripe::setApiKey(config('services.stripe.secret'));
    //         return Product::retrieve($this->shop_package);
    //     }
    //     return null;
    // }

    public function getServicePackageNameAttribute()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        if (!empty($this->shop_package)) {
            try {
                $sub = Product::retrieve($this->shop_package);
                return $sub?->name;
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }


    public function getShopPkgAttribute()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        if ($this->role == 2 && !empty($this->dealer_id)) {
            $user = User::find($this->dealer_id);

            if ($user && !empty($user->shop_package)) {
                try {
                    return Product::retrieve($user->shop_package);
                } catch (\Exception $e) {
                    return null;
                }
            }
        } elseif (!empty($this->shop_package)) {
            try {
                return Product::retrieve($this->shop_package);
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }


    public function getAdsPkgAttribute()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        if ($this->role == 2 && !empty($this->dealer_id)) {
            $user = User::find($this->dealer_id);

            if ($user && !empty($user->package)) {
                try {
                    return Product::retrieve($user->package);
                } catch (\Exception $e) {
                    return null;
                }
            }
        } elseif (!empty($this->package)) {
            try {
                return Product::retrieve($this->package);
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;
    }


    public function getTotalAdsCountAttribute()
    {
        if ($this->role == 2) {
            $car_ads = Post::where('dealer_id', $this->dealer_id)->count();
            $bike_ads = BikePost::where('dealer_id', $this->dealer_id)->count();
            return $car_ads + $bike_ads;
        } else {
            $car_ads = Post::where('dealer_id', $this->id)->count();
            $bike_ads = BikePost::where('dealer_id', $this->id)->count();
            return $car_ads + $bike_ads;
        }
    }

    public function shop() {
        return $this->hasOne(Shops::class, 'dealer_id');
    }
}
