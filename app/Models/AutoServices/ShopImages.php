<?php

namespace App\Models\Autoservices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopImages extends Model
{
    use HasFactory;

    protected $table = 'shop_images';
    protected $guarded = [];

   public function getPathAttribute($value)
   {
       return $value ? asset('storage/' . $value) : null;
   }
}
