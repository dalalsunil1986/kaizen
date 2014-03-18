<?php

class PostsTableSeeder extends Seeder {
    public function run()
    {
        DB::table('posts')->truncate();
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 30; $i++)
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
