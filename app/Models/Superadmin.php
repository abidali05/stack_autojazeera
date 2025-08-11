<?php


namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Superadmin extends Model implements AuthenticatableContract
{
    use Authenticatable;

    // Define the fillable or guarded attributes
    protected $fillable = ['name', 'email', 'password','image','role'];

    // Optionally, define any other attributes
}