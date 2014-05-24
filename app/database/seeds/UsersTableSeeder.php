<?php

use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder {

    public function run()
    {

//        DB::table('users')->truncate();
        $users = array(
            array(
                'username'      => 'ad_user',
                'email'      => 'z4ls@live.com',
                'password'   => Hash::make('admin'),
                'confirmed'   => 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'username'      => 'moderator',
                'email'      => 'moderator@gmail.com',
                'password'   => Hash::make('abc'),
                'confirmed'   => 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ),
            array(
                'username'      => 'author',
                'email'      => 'author@gmail.com',
                'password'   => Hash::make('abc'),
                'confirmed'   => 1,
                'confirmation_code' => md5(microtime().Config::get('app.key')),
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            )
        );

        DB::table('users')->insert( $users );

//        $faker = Faker\Factory::create();
//        for ($i = 0; $i < 5; $i++)
//        {
//            $users = array([
//                'username' => $faker->userName,
//                'email' => $faker->email,
//                'password'=> Hash::make('123'),
//                'first_name'=> $faker->firstName,
//                'second_name'=>$faker->lastName,
//                'last_name' =>$faker->lastName,
//                'phone' => $faker->phoneNumber,
//                'mobile'=> $faker->phoneNumber,
//                'gender' => $faker->randomElement(['male', 'female']),
//                'created_at' => new DateTime,
//                'updated_at' => new DateTime
//            ]);
//            DB::table('users')->insert( $users );
//        }

    }

}
