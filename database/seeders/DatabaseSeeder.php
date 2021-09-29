<?php

	namespace Database\Seeders;

	use App\Models\Category;
	use App\Models\Option;
	use App\Models\SubCategory;
   use App\Models\User;
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
			User::factory(10)->create();
			Category::factory(30)->create();
			Option::factory(30)->create();
			SubCategory::factory(30)->create();
		}
	}
