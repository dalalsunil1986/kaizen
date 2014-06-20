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
            'email'   =>'z4ls@live.com',
            'phone'   => '53234',
            'mobile'  => '2122',
            'username'=> 'Kaizen Admin'
        ]);
        DB::table('contacts')->insert($contacts);
	}

}