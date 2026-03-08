<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('trades')->insert([
            [
                'title' => 'Abrindo espaço',
                'description' => 'Preciso abrir espaço, então desejo uma nova casa para estes camaradas',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Vendendo memórias',
                'description' => 'Vou me mudar e não posso leva-los comigo, estão em boas condições, usados moderadamente',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Abrindo espaço',
                'description' => 'Preciso abrir espaço, então desejo uma nova casa para estes camaradas',
                'user_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Vendendo memórias',
                'description' => 'Vou me mudar e não posso leva-los comigo, estão em boas condições, usados moderadamente',
                'user_id' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Abrindo espaço',
                'description' => 'Preciso abrir espaço, então desejo uma nova casa para estes camaradas',
                'user_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Vendendo memórias',
                'description' => 'Vou me mudar e não posso leva-los comigo, estão em boas condições, usados moderadamente',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Abrindo espaço',
                'description' => 'Preciso abrir espaço, então desejo uma nova casa para estes camaradas',
                'user_id' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Vendendo memórias',
                'description' => 'Vou me mudar e não posso leva-los comigo, estão em boas condições, usados moderadamente',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Abrindo espaço',
                'description' => 'Preciso abrir espaço, então desejo uma nova casa para estes camaradas',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => 'Vendendo memórias',
                'description' => 'Vou me mudar e não posso leva-los comigo, estão em boas condições, usados moderadamente',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            
        ]);
    }
}
