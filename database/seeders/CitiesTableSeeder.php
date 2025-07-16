<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
 DB::table('cities')->delete();

 $cities = array(
    // Punjab Cities
    array('name' => "Lahore", 'state_id' => 1),
    array('name' => "Faisalabad", 'state_id' => 1),
    array('name' => "Rawalpindi", 'state_id' => 1),
    array('name' => "Gujranwala", 'state_id' => 1),
    array('name' => "Multan", 'state_id' => 1),
    array('name' => "Sialkot", 'state_id' => 1),
    array('name' => "Bahawalpur", 'state_id' => 1),
    array('name' => "Sargodha", 'state_id' => 1),
    array('name' => "Sheikhupura", 'state_id' => 1),
    array('name' => "Mandi Bahauddin", 'state_id' => 1),
    array('name' => "Rahim Yar Khan", 'state_id' => 1),
    array('name' => "Gujrat", 'state_id' => 1),
    array('name' => "Okara", 'state_id' => 1),
    array('name' => "Sahiwal", 'state_id' => 1),
    array('name' => "Chiniot", 'state_id' => 1),
    array('name' => "Khanewal", 'state_id' => 1),
    array('name' => "Dera Ghazi Khan", 'state_id' => 1),
    array('name' => "Vehari", 'state_id' => 1),
    array('name' => "Attock", 'state_id' => 1),
    array('name' => "Chakwal", 'state_id' => 1),
    array('name' => "Bhakkar", 'state_id' => 1),
    array('name' => "Layyah", 'state_id' => 1),
    array('name' => "Lodhran", 'state_id' => 1),
    array('name' => "Hafizabad", 'state_id' => 1),
    array('name' => "Pakpattan", 'state_id' => 1),
    array('name' => "Muzaffargarh", 'state_id' => 1),
    array('name' => "Rajanpur", 'state_id' => 1),
    array('name' => "Toba Tek Singh", 'state_id' => 1),
    array('name' => "Khushab", 'state_id' => 1),

    // Sindh Cities
    array('name' => "Karachi", 'state_id' => 2),
    array('name' => "Hyderabad", 'state_id' => 2),
    array('name' => "Sukkur", 'state_id' => 2),
    array('name' => "Larkana", 'state_id' => 2),
    array('name' => "Nawabshah", 'state_id' => 2),
    array('name' => "Mirpurkhas", 'state_id' => 2),
    array('name' => "Shikarpur", 'state_id' => 2),
    array('name' => "Jacobabad", 'state_id' => 2),
    array('name' => "Khairpur", 'state_id' => 2),
    array('name' => "Badin", 'state_id' => 2),
    array('name' => "Thatta", 'state_id' => 2),
    array('name' => "Dadu", 'state_id' => 2),
    array('name' => "Umerkot", 'state_id' => 2),
    array('name' => "Sanghar", 'state_id' => 2),
    array('name' => "Ghotki", 'state_id' => 2),
    array('name' => "Kashmore", 'state_id' => 2),
    array('name' => "Matiari", 'state_id' => 2),
    array('name' => "Jamshoro", 'state_id' => 2),
    array('name' => "Qambar Shahdadkot", 'state_id' => 2),

    // Khyber Pakhtunkhwa Cities
    array('name' => "Peshawar", 'state_id' => 3),
    array('name' => "Mardan", 'state_id' => 3),
    array('name' => "Swat", 'state_id' => 3),
    array('name' => "Abbottabad", 'state_id' => 3),
    array('name' => "Kohat", 'state_id' => 3),
    array('name' => "Bannu", 'state_id' => 3),
    array('name' => "Dera Ismail Khan", 'state_id' => 3),
    array('name' => "Mansehra", 'state_id' => 3),
    array('name' => "Charsadda", 'state_id' => 3),
    array('name' => "Nowshera", 'state_id' => 3),
    array('name' => "Swabi", 'state_id' => 3),
    array('name' => "Lakki Marwat", 'state_id' => 3),
    array('name' => "Haripur", 'state_id' => 3),
    array('name' => "Malakand", 'state_id' => 3),
    array('name' => "Karak", 'state_id' => 3),
    array('name' => "Tank", 'state_id' => 3),
    array('name' => "Lower Dir", 'state_id' => 3),
    array('name' => "Upper Dir", 'state_id' => 3),
    array('name' => "Buner", 'state_id' => 3),

    // Balochistan Cities
    array('name' => "Quetta", 'state_id' => 4),
    array('name' => "Gwadar", 'state_id' => 4),
    array('name' => "Turbat", 'state_id' => 4),
    array('name' => "Khuzdar", 'state_id' => 4),
    array('name' => "Sibi", 'state_id' => 4),
    array('name' => "Zhob", 'state_id' => 4),
    array('name' => "Hub", 'state_id' => 4),
    array('name' => "Dera Murad Jamali", 'state_id' => 4),
    array('name' => "Loralai", 'state_id' => 4),
    array('name' => "Chaman", 'state_id' => 4),
    array('name' => "Panjgur", 'state_id' => 4),
    array('name' => "Mastung", 'state_id' => 4),
    array('name' => "Kharan", 'state_id' => 4),
    array('name' => "Awaran", 'state_id' => 4),
    array('name' => "Musakhel", 'state_id' => 4),
    array('name' => "Jaffarabad", 'state_id' => 4),
    array('name' => "Washuk", 'state_id' => 4),

    // Islamabad Capital Territory Cities
    array('name' => "Islamabad", 'state_id' => 5),

    // Azad Jammu and Kashmir Cities
    array('name' => "Muzaffarabad", 'state_id' => 6),
    array('name' => "Mirpur", 'state_id' => 6),
    array('name' => "Kotli", 'state_id' => 6),
    array('name' => "Bagh", 'state_id' => 6),
    array('name' => "Bhimber", 'state_id' => 6),
    array('name' => "Neelum", 'state_id' => 6),
    array('name' => "Poonch", 'state_id' => 6),
    array('name' => "Hattian Bala", 'state_id' => 6),

    // Gilgit-Baltistan Cities
    array('name' => "Gilgit", 'state_id' => 7),
    array('name' => "Skardu", 'state_id' => 7),
    array('name' => "Hunza", 'state_id' => 7),
    array('name' => "Diamer", 'state_id' => 7),
    array('name' => "Ghizer", 'state_id' => 7),
    array('name' => "Astore", 'state_id' => 7),
    array('name' => "Ghanche", 'state_id' => 7)
);
        DB::table('cities')->insert($cities);
    }
}
