<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
             'id' => 1,
             'name' => 'Test User',
             'email' => 'test@example.com',
             'password' => bcrypt('123456')
         ]);


         //feed
         \App\Models\Feed::create([
            'user_id' => 1,
            'description' => 'hello',
        ]);

                 //Comment
        \App\Models\Comment::create([
              'user_id' => 1,
              'feed_id' => 1,
              'comment' =>'Good Job'
         ]);


             //Like
         \App\Models\Like::create([
            'user_id' => 1,
            'feed_id' => 1,
        ]);
    }
}
