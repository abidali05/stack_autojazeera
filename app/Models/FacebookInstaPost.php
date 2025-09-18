<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookInstaPost extends Model
{
    use HasFactory;
    protected $table = 'facebook_insta_posts';
    protected $guarded = [];
}
