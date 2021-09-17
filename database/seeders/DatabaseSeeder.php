<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Option;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(50)->create();
        Category::factory(50)->create();
        Option::factory(50)->create();
        SubCategory::factory(50)->create();
    }
}
