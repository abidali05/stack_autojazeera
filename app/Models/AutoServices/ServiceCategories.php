<?php

namespace App\Models\AutoServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategories extends Model
{
    use HasFactory;

    protected $table = 'service_categories';
    protected $guarded = [];


    public function getIconAttribute($value)
    {
        return asset('storage/' . $value);
    }
	
	  public function getAppIconAttribute($value)
    {
        return asset('storage/' . $value);
    }
	
}
