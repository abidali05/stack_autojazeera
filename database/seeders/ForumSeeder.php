<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ForumCategory;

class ForumSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'General Discussion',
                'description' => 'General automotive discussions and topics'
            ],
            [
                'name' => 'Car Reviews',
                'description' => 'Share your car reviews and experiences'
            ],
            [
                'name' => 'Buying & Selling',
                'description' => 'Tips and advice for buying and selling vehicles'
            ],
            [
                'name' => 'Technical Support',
                'description' => 'Get help with technical issues and maintenance'
            ],
            [
                'name' => 'Bike Discussion',
                'description' => 'Everything about motorcycles and bikes'
            ]
        ];

        foreach ($categories as $category) {
            ForumCategory::create($category);
        }
    }
}