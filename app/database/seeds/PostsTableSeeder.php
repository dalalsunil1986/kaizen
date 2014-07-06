<?php

class PostsTableSeeder extends Seeder {
    public function run()
    {
        DB::table('posts')->truncate();

        $faker = Faker\Factory::create();
        for ($i = 0; $i < 1; $i++)
        {
            $sentence = $faker->sentence(5);
            $slug = Str::slug($sentence);

            $user = User::orderBy(DB::raw('RAND()'))->first()->id;
            $category = Category::orderBy(DB::raw('RAND()'))->first()->id;
            $posts = array(
                [
                    'user_id'    => $user,
                    'category_id'=> $category,
                    'title'      => $sentence,
                    'slug'       => $slug,
                    'content'    => $faker->sentence(200),
                    'created_at' => $faker->DateTime(),
                    'updated_at' => $faker->DateTime()
                ]
            );
            DB::table('posts')->insert($posts);
        }
    }

}
