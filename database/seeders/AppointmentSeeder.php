<?php

namespace Database\Seeders;

use App\Models\Appointment;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < 100; $i++) {
            Appointment::create([
                'service_id' => $faker->numberBetween(1, 5),
                'first_name' => $faker->firstName,
                'last_name'  => $faker->lastName,
                'phone'      => $faker->phoneNumber,
                'email'      => $faker->email,
                'location'   => $faker->address,
                'message'    => $faker->sentence,
            ]);
        }
    }
}
