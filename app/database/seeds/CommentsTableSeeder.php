<?php

class CommentsTableSeeder extends Seeder {


    public function run()
    {
        DB::table('comments')->truncate();

        $faker = Faker\Factory::create();
        for ($i = 0; $i < 20; $i++)
        {
            $user = User::orderBy(DB::raw('RAND()'))->first()->id;
            $event = EventModel::orderBy(DB::raw('RAND()'))->first()->id;
            $post = Post::orderBy(DB::raw('RAND()'))->first()->id;
            $comments = array(
                [
                    'user_id'    => $user,
                    'commentable_id' => $faker->randomElement([$event,$post]),
                    'commentable_type' => $faker->randomElement(['EventModel','Post']),
                    'content'    => $faker->sentence(30),
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime
                ]
            );

            DB::table('comments')->insert($comments);

        }
    }

}
