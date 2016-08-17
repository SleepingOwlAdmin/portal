<?php

use App\Post;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::truncate();

        factory(Post::class, 20)->create();
    }
}