<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

// use CitiesTableSeeder;

use App\Models\Superadmin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

// use StatesTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $pass="12345678";
        Superadmin::Create([
            'name'=>"superadmin",
            'password'=>Hash::make($pass),
            'email'=>"admin@gmail.com"
    
    
    
    
    ]);
        $this->call(CountriesTableSeeder::class);
        // $this->call(StatesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(ProvinceTableSeeder::class);
        $this->call(ForumDataSeeder::class);
        // $this->call(PermissionsTableSeeder::class);
    }
}
