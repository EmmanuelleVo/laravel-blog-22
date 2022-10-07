<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for ($i = 0; $i < 7; $i++) {
            $name = strtolower(substr($faker->sentence(2), 0, -1));
            $slug = Str::slug($name);
            DB::table('categories')->insert(compact(
                'name', 'slug'
            ));
        }
    }
}
