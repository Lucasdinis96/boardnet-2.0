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

        DB::table('users')->insert([
            [
                'name' => 'Test User 01',
                'email' => 'test01@example.com',
                'password' => bcrypt('teste01'),
                'birthdate' => Carbon::parse('1989-07-21'),
                'phone' => '554299542315',
                'address' => 'Rua das Flores',
                'number' => '2314',
                'neighborhood' => 'Campo das Flores',
                'cep' => '87263-928',
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
                'address' => 'Rua das Flores',
                'number' => '3451',
                'neighborhood' => 'Campo das Flores',
                'cep' => '82463-928',
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
                'address' => 'Rua das Flores',
                'number' => '2256',
                'neighborhood' => 'Campo das Flores',
                'cep' => '87263-122',
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
                'address' => 'Rua das Flores',
                'number' => '2244',
                'neighborhood' => 'Campo das Flores',
                'cep' => '87263-267',
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
                'address' => 'Rua das Flores',
                'number' => '344',
                'neighborhood' => 'Campo das Flores',
                'cep' => '87263-245',
                'city_id' => City::inRandomOrder()->first()->id,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
