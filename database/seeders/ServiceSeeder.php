<?php

namespace Database\Seeders;

use App\Models\Service;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 100; $i++) {
            $title = $faker->sentence();
            Service::create([
                'icon'      => $faker->imageUrl(),
                'title'     => $title,
                'slug'      => Str::slug($title),
                'thumbnail' => $faker->imageUrl(),
                'slogan'    => $faker->sentence(),
                'content'   => $faker->paragraph(),
            ]);
        }
    }
}
