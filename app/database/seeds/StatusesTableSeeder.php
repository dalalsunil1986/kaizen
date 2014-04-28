<?php

class StatusesTableSeeder extends Seeder {
	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		// DB::table('subscriptions')->truncate();

        $faker = Faker\Factory::create();
        for ($i = 0; $i < 40; $i++)
        {

            $event = EventModel::orderBy(DB::raw('RAND()'))->first()->id;
            $user = User::orderBy(DB::raw('RAND()'))->first()->id;

            $subscriptions = array(
                [
                    'user_id'=> $user,
                    'event_id' => $event,
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime
                ]
            );
            DB::table('statuses')->insert($subscriptions);

        }
		// Uncomment the below to run the seeder

//        $this->updateEventsTable();
	}

    public function updateEventsTable() {
        $events  = EventModel::all();
        foreach ($events as $event) {
            $count = Subscription::findEventCount($event->id);
            EventModel::fixEventCounts($event->id,$count);
        }
    }

}
