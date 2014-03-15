<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class ContactsTableSeeder extends Seeder {

	public function run()
	{
        DB::table('contacts')->truncate();
        $faker = Faker::create();

        $contacts = array([
            'address' => $faker->address,
            'email'   => $faker->email,
            'phone'   => $faker->phoneNumber,
            'mobile'  => $faker->phoneNumber
        ]);
        DB::table('contacts')->insert($contacts);
	}

}