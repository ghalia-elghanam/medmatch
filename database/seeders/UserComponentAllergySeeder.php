<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserComponentAllergySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_allergy_component = [

            [
                'user_id' => 6,
                'user_allergy_component_id' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 7,
                'user_allergy_component_id' => 14,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'user_id' => 8,
                'user_allergy_component_id' => 19,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        collect($user_allergy_component)->chunk(5)->each(function ($chunk) {
            DB::table('user_allergy_component')->insert($chunk->toArray());
        });
    }
}
