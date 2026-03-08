<?php

namespace Database\Seeders;

use App\Models\City;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('users')->insert([
            [
                'name' => 'Test User 01',
                'email' => 'test01@example.com',
                'password' => bcrypt('teste01'),
                'birthdate' => Carbon::parse('1989-07-21'),
                'phone' => '554299542315',
                'city_id' => City::inRandomOrder()->first()->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Test User 02',
                'email' => 'test02@example.com',
                'password' => bcrypt('teste02'),
                'birthdate' => Carbon::parse('2003-09-12'),
                'phone' => '55429988752345',
                'city_id' => City::inRandomOrder()->first()->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Test User 03',
                'email' => 'test03@example.com',
                'password' => bcrypt('teste03'),
                'birthdate' => Carbon::parse('2000-10-15'),
                'phone' => '5542988890352',
                'city_id' => City::inRandomOrder()->first()->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Test User 04',
                'email' => 'test04@example.com',
                'password' => bcrypt('teste04'),
                'birthdate' => Carbon::parse('2000-10-15'),
                'phone' => '5542988890352',
                'city_id' => City::inRandomOrder()->first()->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Test User 05',
                'email' => 'test05@example.com',
                'password' => bcrypt('teste05'),
                'birthdate' => Carbon::parse('2000-10-15'),
                'phone' => '5542988890352',
                'city_id' => City::inRandomOrder()->first()->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
