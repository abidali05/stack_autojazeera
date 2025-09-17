<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ForumSeederCommand extends Seeder
{
    public function run()
    {
        $this->call([
            ForumSeeder::class,
            ForumDataSeeder::class,
        ]);
    }
}