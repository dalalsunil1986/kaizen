<?php


class CategoriesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
//        DB::table('categories')->truncate();
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 10; $i++)
        {
            $categories = array(
                [
                    'parent_id' => '0',
                    'name' => $faker->name,
                    'name_en' => $faker->name,
                    'slug' => $faker->name,
                    'type'=>$faker->randomElement(['EventModel','Post']),
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime
                ]
            );
            DB::table('categories')->insert($categories);
        }
		// Uncomment the below to run the seeder

	}

}
