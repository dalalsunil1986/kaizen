<?php

class FollowersTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
//		 DB::table('followers')->truncate();

        $faker = Faker\Factory::create();
        for ($i = 0; $i < 40; $i++)
        {

            $event = EventModel::orderBy(DB::raw('RAND()'))->first()->id;
            $user = User::orderBy(DB::raw('RAND()'))->first()->id;

            $followers = array(
                [
                    'user_id'=> $user,
                    'event_id' => $event,
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime
                ]
            );
            DB::table('followers')->insert($followers);

        }

		// Uncomment the below to run the seeder
	}

}
