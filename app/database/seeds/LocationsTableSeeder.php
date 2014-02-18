<?php

class LocationsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		 DB::table('locations')->truncate();
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 20; $i++)
        {
            $country = Country::orderBy(DB::raw('RAND()'))->first()->id;
            $locations = array(
                [
                    'country_id' => $country,
                    'name' => $faker->city,
                    'name_en'=> $faker->city,
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime
                ]
            );

            // Uncomment the below to run the seeder
             DB::table('locations')->insert($locations);
        }
	}

}
