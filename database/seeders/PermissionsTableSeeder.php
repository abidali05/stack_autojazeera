<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->insert([
            ['name' => 'Post Ads'],
            ['name' => 'Manage Ads'],
            ['name' => 'View Leads'],
            ['name' => 'Manage Users'],
        ]);
    }
}
