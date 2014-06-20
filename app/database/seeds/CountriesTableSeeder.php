<?php

class CountriesTableSeeder extends Seeder {

	public function run()
	{
        DB::table('countries')->truncate();

        $countries = array(
            array(
                'name' => 'الكويت',
                'name_en' =>'Kuwait',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'name' => 'السعودية',
                'name_en' =>'Saudi',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'name' => 'عمان',
                'name_en' =>'Oman',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'name' => 'الإمارات',
                'name_en' =>'UAE',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'name' => 'قطر',
                'name_en' =>'Qatar',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'name' => 'بحرين',
                'name_en' =>'Bahrain',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
        );
        DB::table('countries')->insert($countries);

    }

}
