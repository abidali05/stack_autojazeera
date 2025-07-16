<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function mainfeature()
    {
        return $this->hasOne(MainFeature::class, 'id', 'feature_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
