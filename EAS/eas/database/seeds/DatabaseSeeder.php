<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // DB::table('posts')->insert([
        //     'title' => str_random(10),
        //     'body' => str_random(100),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        //     'cover_image' => 'noimage.jpg',
        // ]);
        factory(App\Post::class,250)->create();
    }
}
