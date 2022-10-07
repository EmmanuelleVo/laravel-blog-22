<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for ($i = 0; $i < 100; $i++) {
            $created_at = Carbon::create($faker->dateTimeBetween('-3 years', 'now')->format('Y-m-d H:i:s'));
            $published_at = $created_at->addDays(rand(0, 1) * rand(2, 20));
            $updated_at = rand(0, 10) ? $created_at : $created_at->addWeeks(rand(2, 8));
            $deleted_at = rand(0, 10) ? null : Carbon::now();
            $user_id = DB::table('users')->inRandomOrder()->first()->id;
            $title = $faker->sentence(10);
            $slug = Str::slug($title);
            $excerpt = $faker->sentence(40);
            $thumbnail = $faker->imageUrl(640, 480, true, 'landscape');
            $body = '<p>' . implode('</p><p>', $faker->paragraphs(12)) . '</p>';
            DB::table('posts')->insert(
                compact('title', 'slug', 'excerpt', 'user_id', 'body', 'created_at', 'updated_at', 'deleted_at', 'published_at', 'thumbnail')
            );
        }
    }
}
