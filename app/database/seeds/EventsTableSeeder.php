<?php

class EventsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		 DB::table('events')->truncate();
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 50; $i++)
        {

            $category = Category::orderBy(DB::raw('RAND()'))->first()->id;
            $user = User::orderBy(DB::raw('RAND()'))->first()->id;
            $location = Location::orderBy(DB::raw('RAND()'))->first()->id;
            $events = array(
                [
                    'category_id' => $category,
                    'user_id' => $user,
                    'location_id' => $location,
                    'title' => $faker->sentence(2),
                    'title_en' => $faker->sentence(2),
                    'description' => $faker->sentence(50),
                    'description_en'=>$faker->sentence(50),
                    'price'=> '440',
                    'total_seats' => '15',
                    'available_seats' => '0',
                    'slug'=> $faker->sentence(10),
                    'date_start' =>new DateTime,
                    'date_end' => new DateTime,
                    'time_start' => $faker->time(),
                    'time_end' => $faker->time(),
                    'address' => $faker->address,
                    'address_en' => $faker->address,
                    'street' => $faker->streetAddress,
                    'street_en' => $faker->streetAddress,
                    'latitude' => $faker->latitude,
                    'longitude' => $faker->longitude,
                    'active' =>(bool) rand(0, 1),
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime,
                    'free' => $faker->boolean()
                ]

		    );
            DB::table('events')->insert($events);

        }

		// Uncomment the below to run the seeder
	}

}
