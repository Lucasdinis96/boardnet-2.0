<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TradeItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('trade_items')->insert([
            [
                'trade_id' => 1,
                'boardgame_id' => 3,
                'value' => 134.98,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 2,
                'boardgame_id' => 2,
                'value' => 215.47,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 2,
                'boardgame_id' => 1,
                'value' => 342.85,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 3,
                'boardgame_id' => 10,
                'value' => 489.33,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 3,
                'boardgame_id' => 5,
                'value' => 157.26,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 4,
                'boardgame_id' => 7,
                'value' => 628.74,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 4,
                'boardgame_id' => 9,
                'value' => 791.58,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 5,
                'boardgame_id' => 2,
                'value' => 284.19,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 5,
                'boardgame_id' => 10,
                'value' => 913.67,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 6,
                'boardgame_id' => 8,
                'value' => 176.94,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 6,
                'boardgame_id' => 3,
                'value' => 357.81,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 7,
                'boardgame_id' => 8,
                'value' => 524.63,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 7,
                'boardgame_id' => 3,
                'value' => 698.42,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 8,
                'boardgame_id' => 8,
                'value' => 845.27,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 8,
                'boardgame_id' => 3,
                'value' => 132.56,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 9,
                'boardgame_id' => 8,
                'value' => 463.18,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 9,
                'boardgame_id' => 3,
                'value' => 779.91,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 10,
                'boardgame_id' => 8,
                'value' => 956.34,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 10,
                'boardgame_id' => 3,
                'value' => 247.69,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
        
    }
}
