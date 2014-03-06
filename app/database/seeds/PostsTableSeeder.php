<?php

class PostsTableSeeder extends Seeder {
    public function run()
    {
        DB::table('posts')->truncate();
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 30; $i++)
        {
            $user = User::orderBy(DB::raw('RAND()'))->first()->id;
            $category = Category::orderBy(DB::raw('RAND()'))->first()->id;
            $posts = array(
                [
                    'user_id'    => $user,
                    'category_id'=> $category,
                    'title'      => $faker->sentence(20),
                    'slug'       => $faker->sentence(20),
                    'content'    => $faker->sentence(40),
                    'meta_title' => 'meta_title1',
                    'meta_description' => 'meta_description1',
                    'meta_keywords' => 'meta_keywords1',
                    'created_at' => $faker->DateTime(),
                    'updated_at' => $faker->DateTime()
                ]
            );
            DB::table('posts')->insert($posts);
        }
    }

}
