<?php

namespace App\Models\AutoServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopServices extends Model
{
    use HasFactory;

    protected $table = 'shop_services';
    protected $guarded = [];
    public $appends = ['service_name'];

   public function service()
   {
       return $this->belongsTo(Services::class, 'service_id', 'id');
   }
   
   public function getServiceNameAttribute()
   {
       return $this->service->name ?? null;
   }

}
