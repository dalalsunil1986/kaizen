<?php

class EventsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		 DB::table('events')->truncate();
        $faker = Faker\Factory::create();
        $dt = Carbon::now();
        $dateNow = $dt->toDateTimeString();
        for ($i = 0; $i < 50; $i++)
        {

            $category = Category::getEventCategories()->orderBY(DB::raw('RAND()'))->first()->id;
            $user = User::orderBy(DB::raw('RAND()'))->first()->id;
            $location = Location::orderBy(DB::raw('RAND()'))->first()->id;
            $max_seats = 15;
            $total_seats = $faker->numberBetween(1,$max_seats);
            $available_seats = $max_seats - $total_seats;
            $events = array(
                [
                    'category_id' => $category,
                    'user_id' => $user,
                    'location_id' => $location,
                    'title' => $faker->sentence(3),
                    'title_en' => $faker->sentence(3),
                    'description' => $faker->sentence(50),
                    'description_en'=>$faker->sentence(50),
                    'price'=> '440',
                    'total_seats' => $total_seats,
                    'available_seats' => $available_seats,
                    'slug'=> $faker->sentence(10),
                    'date_start' =>$dateNow,
                    'date_end' => $dateNow,
                    'address' => $faker->address,
                    'address_en' => $faker->address,
                    'street' => $faker->streetAddress,
                    'street_en' => $faker->streetAddress,
                    'latitude' => $faker->latitude,
                    'longitude' => $faker->longitude,
                    'active' =>(bool) rand(0, 1),
                    'created_at' => $dateNow,
                    'updated_at' => $dateNow,
                    'free' => $faker->boolean(),
                    'button' => 'سجل',
                    'button_en'=>'Subscribe'
                ]

		    );
            DB::table('events')->insert($events);




        }

		// Uncomment the below to run the seeder
	}

}
