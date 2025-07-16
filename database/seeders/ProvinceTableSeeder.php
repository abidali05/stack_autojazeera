<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class ProvinceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('provinces')->delete();


        $provinces = array(
        array('name' => "Punjab",'country_id' => 166),
        array('name' => "Sindh",'country_id' => 166),
        array('name' => "Khyber Pakhtunkhwa",'country_id' => 166),
        array('name' => "Balochistan",'country_id' => 166),
        array('name' => "Islamabad",'country_id' => 166),
        array('name' => "Azad Jammu & Kashmir",'country_id' => 166),
        array('name' => "Gilgit-Baltistan",'country_id' => 166),
      
        
        
        
        
                );
                DB::table('provinces')->insert($provinces);
            }
    
}
