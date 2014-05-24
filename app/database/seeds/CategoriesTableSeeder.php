<?php


class CategoriesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
//        DB::table('categories')->truncate();
        $faker = Faker\Factory::create();

            $categories = array(
                [
                    'parent_id' => '0',
                    'name' => 'دورة ا',
                    'name_en' => 'Category 1',
                    'slug' => $faker->name,
                    'type'=> 'EventModel',
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime
                ],
                [
                    'parent_id' => '0',
                    'name' => 'شسشس',
                    'name_en' => 'Category 2',
                    'slug' => $faker->name,
                    'type'=>'Post',
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime
                ],
                [
                    'parent_id' => '0',
                    'name' => 'شسيش',
                    'name_en' => 'Category 3',
                    'slug' => $faker->name,
                    'type'=>'EventModel',
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime
                ],

            );
            DB::table('categories')->insert($categories);

		// Uncomment the below to run the seeder

	}

}
