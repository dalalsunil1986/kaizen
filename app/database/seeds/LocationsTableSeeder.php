<?php

class LocationsTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
//		 DB::table('locations')->truncate();

        $country = Country::where('name_en','Kuwait')->first();
        $locations = array(
            [
                'country_id' => $country->id,
                'name' => 'سالمية',
                'name_en'=> 'Salmiya',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
                'parent_id' => 1
            ]
        );

        // Uncomment the below to run the seeder
         DB::table('locations')->insert($locations);
    }


}
