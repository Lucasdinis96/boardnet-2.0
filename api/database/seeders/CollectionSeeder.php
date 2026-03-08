<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('collections')->insert([
            [
                'user_id' => 1,
                'boardgame_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'user_id' => 3,
                'boardgame_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
