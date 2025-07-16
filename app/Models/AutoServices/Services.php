<?php

namespace App\Models\AutoServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $guarded = [];
    protected $appends = ['category_name'];

    public function getIconAttribute($value)
    {
        return asset('storage/' . $value);
    }

    public function getCategoryNameAttribute()
    {
        return ServiceCategories::where('id', $this->category_id)->value('name');
    }

    public function category(){
        return $this->belongsTo(ServiceCategories::class, 'category_id');
    }
}
