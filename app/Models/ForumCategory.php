<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function threads()
    {
        return $this->hasMany(ForumThread::class, 'category_id');
    }

    public function latestThreads()
    {
        return $this->hasMany(ForumThread::class, 'category_id')    
                ->latest()
                ->take(4);
    }
}