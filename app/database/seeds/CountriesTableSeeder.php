<?php

class CountriesTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		 DB::table('countries')->truncate();

        $faker = Faker\Factory::create();
        for ($i = 0; $i < 6; $i++)
        {
		    $countries = array(
                [
                    'name' => $faker->country,
                    'name_en' =>$faker->country,
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime
                ]
            );

            // Uncomment the below to run the seeder
             DB::table('countries')->insert($countries);
        }
	}

}
