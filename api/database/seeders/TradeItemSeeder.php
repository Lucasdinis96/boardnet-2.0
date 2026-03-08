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
        DB::table('tradeItens')->insert([
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
                'value' => 157.32,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 2,
                'boardgame_id' => 1,
                'value' => 157.32,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 3,
                'boardgame_id' => 10,
                'value' => 157.32,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 3,
                'boardgame_id' => 5,
                'value' => 157.32,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 4,
                'boardgame_id' => 7,
                'value' => 157.32,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 4,
                'boardgame_id' => 9,
                'value' => 157.32,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 5,
                'boardgame_id' => 2,
                'value' => 157.32,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 5,
                'boardgame_id' => 10,
                'value' => 157.32,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 6,
                'boardgame_id' => 8,
                'value' => 157.32,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 6,
                'boardgame_id' => 3,
                'value' => 157.32,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 7,
                'boardgame_id' => 8,
                'value' => 157.32,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 7,
                'boardgame_id' => 3,
                'value' => 157.32,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 8,
                'boardgame_id' => 8,
                'value' => 157.32,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 8,
                'boardgame_id' => 3,
                'value' => 157.32,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 9,
                'boardgame_id' => 8,
                'value' => 157.32,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 9,
                'boardgame_id' => 3,
                'value' => 157.32,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 10,
                'boardgame_id' => 8,
                'value' => 157.32,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'trade_id' => 10,
                'boardgame_id' => 3,
                'value' => 157.32,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
        
    }
}
