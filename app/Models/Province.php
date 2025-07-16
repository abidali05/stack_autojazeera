<?php

namespace App\Models;

use App\Models\location;
use App\Models\Bike\BikeLocation;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Province extends Model
{
    use HasFactory;
	 public function city()
    {
      return  $this->hasMany(City::class,'state_id','id');
    }

    protected $appends=['count', 'bike_count'];
    public function getCountAttribute()
    {
         $query = location::join('posts', 'locations.post_id', '=', 'posts.id')
        ->where('locations.province', $this->id)
        ->where('posts.status', 1)
        ->whereNull('posts.deleted_at');

		$path = request()->path();

		if (str_contains($path, 'cars/used')) {
			$query->where('posts.condition', 'used');
		} elseif (str_contains($path, 'cars/new')) { 
			$query->where('posts.condition', 'new');
		}

		return $query->select(DB::raw('COUNT(DISTINCT locations.post_id) as total'))
			->value('total');
		
    }
	
	public function getBikeCountAttribute()
    {
         $query = BikeLocation::join('bikes_posts', 'bike_location.ad_id', '=', 'bikes_posts.id')
        ->where('bike_location.province', $this->id)
        ->where('bikes_posts.status', '1')
        ->whereNull('bikes_posts.deleted_at');

		$path = request()->path();

		if (str_contains($path, 'bikes/used')) {
			$query->where('bikes_posts.condition', 'used');
		} elseif (str_contains($path, 'bikes/new')) { 
			$query->where('bikes_posts.condition', 'new');
		}

		return $query->select(DB::raw('COUNT(DISTINCT bike_location.ad_id) as total'))
			->value('total');
		
    }
}
