<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookToken extends Model
{
    use HasFactory;

     protected $fillable = ['page_id', 'page_access_token'];
}
