<?php

namespace App\Models;

use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    protected $appends = ['makeName', 'modelname', 'username', 'bodytypename', 'excolorname', 'seller_type', 'distance'];
    // protected $fillable = ['previous_price','dealer_id'];


    public function getmakeNameAttribute()
    {
        if (isset($this->make)) {
            $make = MakeCompany::find($this->make);
             return $make ? $make->name : null;
        } else {
            return null;
        }
    }

    public function getbodytypeNameAttribute()
    {
        $body = BodyType::find($this->body_type);

        return $body->name;
    }

    public function getexcolorNameAttribute()
    {
        $color = Color::find($this->exterior_color);

        return $color->name;
    }

    public function getusernameAttribute()
    {
        $user = User::find($this->dealer_id);
        return $user->name;
    }

    public function getModelNameAttribute()
    {
        if ($this->model !== null) {
            $model = ModelCompany::find($this->model);
            // Check if the city exists to avoid trying to access a null object's property
            if ($model) {
                return $model->name;
            }
        }

        return null;
    }

    public function feature()
    {
        return $this->hasMany(Feature::class, 'post_id', 'id');
    }
    public function dealer()
    {
        return $this->hasOne(User::class, 'id', 'dealer_id');
    }
    public function whishlist()
    {
        return $this->hasOne(Whishlist::class, 'post_id', 'id');
    }
    public function location()
    {
        return $this->hasOne(location::class, 'post_id', 'id');
    }
    public function contact()
    {
        return $this->hasOne(ContactInfo::class, 'post_id', 'id');
    }
    public function document()
    {
        return $this->hasMany(Document::class, 'post_id', 'id')->orderBy('position', 'asc');
    }
    public function makecompany()
    {
        return $this->belongsTo(MakeCompany::class, 'make', 'id');
    }
    public function modelcompany()
    {
        return $this->belongsTo(ModelCompany::class, 'model', 'id');
    }
    public function bodytype1()
    {
        return $this->hasOne(BodyType::class, 'id', 'body_type');
    }
    public function make1()
    {
        return $this->hasOne(BodyType::class, 'id', 'make');
    }

    public function getImageAttribute()
    {
        $mainDoc = $this->document->first();
        return $mainDoc ? url('posts/doc/' . $mainDoc->doc_name) : url('web/images/default-car.jpg');
    }

    public function getMileageIconAttribute()
    {
        return 'bi bi-speedometer2';
    }

    public function getTransmissionIconAttribute()
    {
        return 'bi bi-car-front-fill';
    }

    public function getFuelIconAttribute()
    {
        return 'bi bi-fuel-pump-diesel';
    }

    public function getSellerTypeAttribute()
    {
        $post = Post::find($this->id);
        $dealer = User::find($post->dealer_id);
        return $dealer->userType;
    }

public static function getFuelTypeCounts()
{
    $query = self::where('status', 1)
        ->whereNull('posts.deleted_at');

    $path = request()->path();
    if (str_contains($path, 'cars/used')) {
        $query->where('posts.condition', 'used');
    } elseif (str_contains($path, 'cars/new')) {
        $query->where('posts.condition', 'new');
    }

    return $query->selectRaw('fuel, MAX(feature_ad) as feature_ad, COUNT(*) as count')
        ->groupBy('fuel')
        ->orderByDesc('feature_ad') // This now works because we SELECT it
        ->pluck('count', 'fuel')
        ->toArray();
}


public static function getTransmissionCounts()
{
    $query = self::where('status', 1)
        ->whereNull('posts.deleted_at');

    $path = request()->path();
    if (str_contains($path, 'cars/used')) {
        $query->where('posts.condition', 'used');
    } elseif (str_contains($path, 'cars/new')) {
        $query->where('posts.condition', 'new');
    }

    return $query->selectRaw('transmission, MAX(feature_ad) as feature_ad, COUNT(*) as count')
        ->groupBy('transmission')
        ->orderByDesc('feature_ad') // now it's valid since we selected it
        ->pluck('count', 'transmission')
        ->toArray();
}


    public function getDistanceAttribute()
    {
        if (!request()->is('api/*')) return null;
        // return env('GOOGLE_MAP_API'); exit;

        $userLat = request()->header('latitude');
        $userLng = request()->header('longitude');

        if (!$userLat || !$userLng || !$this->latitude || !$this->longitude) {
            return null;
        }

        $response = Http::get("https://maps.googleapis.com/maps/api/distancematrix/json", [
            'origins' => "{$userLat},{$userLng}",
            'destinations' => "{$this->latitude},{$this->longitude}",
            'key' => 'AIzaSyBHTfGE9bbvleasezO-T-j1u5UVm6aTnl0',
            'units' => 'metric',
        ]);

        $data = $response->json();
        // return $data;    

        if ($data['status'] !== 'OK') return null;

        $element = $data['rows'][0]['elements'][0];

        return $element['status'] === 'OK'
            ? $element['distance']['value'] // value is in meters
            : null;
    }

    protected static function booted()
    {
        static::addGlobalScope('featureFirst', function (Builder $builder) {
            $builder->orderByDesc('feature_ad');
        });
    }
}
