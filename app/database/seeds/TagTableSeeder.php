<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class TagTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();

		foreach(range(1, 10) as $index)
		{
			$array =[
                'name_en' => $faker->country,
                'name_ar' => $faker->country
			];
             DB::table('tags')->insert($array);
		}
	}

}