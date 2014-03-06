<?php

use Illuminate\Support\Facades\Hash;

class RolesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('roles')->truncate();

        $faker = Faker\Factory::create();

        $adminRole = new Role;
        $adminRole->name = 'admin';
        $adminRole->save();

        $moderatorRole = new Role;
        $moderatorRole->name = 'moderator';
        $moderatorRole->save();

        $authorRole = new Role;
        $authorRole->name = 'author';
        $authorRole->save();

        $user = User::where('username','=','ad_user')->first();
        $user->attachRole( $adminRole );

        $user = User::where('username','=','ad_user1')->first();
        $user->attachRole( $adminRole );

//        $moderator = array(
//            [
//                'username' => 'moderator',
//                'email' => 'moderator@abc.com',
//                'password'=> Hash::make('123'),
//                'first_name'=> $faker->firstName,
//                'second_name'=>$faker->lastName,
//                'last_name' =>$faker->lastName,
//                'phone' => $faker->phoneNumber,
//                'mobile'=> $faker->phoneNumber,
//                'gender' => $faker->randomElement(['male', 'female']),
//                'created_at' => new DateTime,
//                'updated_at' => new DateTime
//            ]
//        );
//        DB::table('users')->insert($moderator);

//        $author = array(
//            [
//                'username' => 'author',
//                'email' => 'author@abc.com',
//                'password'=> Hash::make('123'),
//                'first_name'=> $faker->firstName,
//                'second_name'=>$faker->lastName,
//                'last_name' =>$faker->lastName,
//                'phone' => $faker->phoneNumber,
//                'mobile'=> $faker->phoneNumber,
//                'gender' => $faker->randomElement(['male', 'female']),
//                'created_at' => new DateTime,
//                'updated_at' => new DateTime
//            ]
//        );
//        DB::table('users')->insert($author);

        $m = User::where('username','=','mo_user')->first();
        $m->attachRole($moderatorRole);
        $m = User::where('username','=','mo_user1')->first();
        $m->attachRole($moderatorRole);

        $a  = User::where('username','=','au_user')->first();
        $a->attachRole($authorRole);
        $a  = User::where('username','=','au_user1')->first();
        $a->attachRole($authorRole);
    }

}
