<?php

namespace App\Models\AutoServices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingServices extends Model
{
    use HasFactory;

    protected $table = 'booking_services';
    protected $guarded = [];
    protected $appends = ['service_name'];
    public $timestamps = false;

    public function shop_service(){
        return $this->belongsTo(ShopServices::class, 'service_id', 'id');
    }

    public function getServiceNameAttribute()
    {
        $shopService = ShopServices::find($this->service_id);

        return Services::find($shopService->service_id)->name ?? 'Unknown Service';
    }
    
}
