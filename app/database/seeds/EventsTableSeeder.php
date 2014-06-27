<?php

use Carbon\Carbon;

class EventsTableSeeder extends Seeder {

    protected $date_start;
    protected $date_end;

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		DB::table('events')->truncate();
        $faker = Faker\Factory::create();
        $dt = Carbon::now();
        $dateNow = $dt->toDateTimeString();

//        for ($i = 0; $i < 1; $i++)
//        {
            $this->setDateStart($dt->addDays($faker->numberBetween(1,20))->toDateTimeString());

            $this->setDateEnd($dt->addDays($faker->numberBetween(2,20))->toDateTimeString());

            $this->checkDate();

            $category = \Acme\Category\EloquentCategoryRepository::getEventCategories()->orderBY(DB::raw('RAND()'))->first()->id;
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
                    'title' => 'كايزن ',
                    'title_en' => 'Kaizen Events',
                    'description' => $faker->sentence(20),
                    'description_en'=>$faker->sentence(20),
                    'price'=> '440',
                    'total_seats' => $total_seats,
                    'available_seats' => $available_seats,
                    'slug'=> $faker->sentence(10),
                    'date_start' =>$this->getDateStart(),
                    'date_end' => $this->getDateEnd(),
                    'phone' => '98989',
                    'email'=>$faker->email,
                    'address' => $faker->address,
                    'address_en' => $faker->address,
                    'street' => $faker->streetAddress,
                    'street_en' => $faker->streetAddress,
                    'latitude' => $faker->latitude,
                    'longitude' => $faker->longitude,
                    'active' =>(bool) rand(0, 1),
                    'featured'=>(bool) rand(0,1),
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
//	}

    /**
     * @return mixed
     */
    public function getDateStart()
    {
        return $this->date_start;
    }

    /**
     * @param mixed $date_start
     */
    public function setDateStart($date_start)
    {
        $this->date_start = $date_start;
    }

    /**
     * @return mixed
     */
    public function getDateEnd()
    {
        return $this->date_end;
    }

    /**
     * @param mixed $date_end
     */
    public function setDateEnd($date_end)
    {
        $this->date_end = $date_end;
    }

    function checkDate() {
        if($this->getDateEnd() > $this->getDateStart()) {
            return $this->setDateEnd($this->getDateEnd());
        } else {
            return $this->checkdate();
        }
    }
}
