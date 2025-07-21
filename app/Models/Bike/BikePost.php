<?php

namespace App\Models\Bike;

use App\Models\Color;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Eloquent\Builder;

class BikePost extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'bikes_posts';
    protected $guarded = [];


    protected $dates = ['deleted_at'];

    protected $appends = ['colorname', 'makename', 'modelname', 'bodytypename', 'shareableLink', 'distance'];
    protected $casts = [
        'previous_price' => 'int',
        'precentage_diff' => 'int',
    ];

    public function features()
    {
        return $this->hasMany(BikeFeature::class, 'ad_id');
    }

    public function media()
    {
        return $this->hasMany(BikeMedia::class, 'ad_id');
    }

    public function location()
    {
        return $this->hasOne(BikeLocation::class, 'ad_id');
    }

    public function contacts()
    {
        return $this->hasOne(BikeContact::class, 'ad_id');
    }

    public function getcolornameAttribute()
    {
        return Color::where('id', $this->color)->first()->name ?? null;
    }

    public function dealer()
    {
        return $this->belongsTo(User::class, 'dealer_id');
    }

    public function getdocumentbrochureAttribute($value)
    {
        if ($value && $value != '' && $value != null) {
            return url($value);
        } else {
            return $value;
        }
    }

    public function getdocumentauctionAttribute($value)
    {
        if ($value && $value != '' && $value != null) {
            return url($value);
        } else {
            return $value;
        }
    }

    public function getmakenameAttribute()
    {
        return BikeMake::where('id', $this->make)->first()->name ?? null;
    }

    public function getmodelnameAttribute()
    {
        return BikeModels::where('id', $this->model)->first()->name ?? null;
    }

    public function getbodytypenameAttribute()
    {
        return BikeBodyTypes::where('id', $this->body_type)->first()->name ?? null;
    }

    public function getshareableLinkAttribute()
    {
        return url('bike-details/' . $this->id);
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
            $builder->orderByDesc('is_featured');
        });
    }


    public static function getFuelTypeCounts()
    {
        $query = self::withoutGlobalScopes()  // <== to ignore any default ORDER BY
            ->where('status', 1)
            ->whereNull('bikes_posts.deleted_at');

        $path = request()->path();
        if (str_contains($path, 'bikes/used')) {
            $query->where('bikes_posts.condition', 'used');
        } elseif (str_contains($path, 'bikes/new')) {
            $query->where('bikes_posts.condition', 'new');
        }

        return $query->selectRaw('fuel_type, COUNT(*) as count')
            ->groupBy('fuel_type')
            ->pluck('count', 'fuel_type')
            ->toArray();
    }
}
