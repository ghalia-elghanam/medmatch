<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAllergySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_allergy = [
            [
                'user_id' => 4,
                'allergy_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 5,
                'allergy_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 6,
                'allergy_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 7,
                'allergy_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        collect($user_allergy)->chunk(5)->each(function ($chunk) {
            DB::table('user_allergy')->insert($chunk->toArray());
        });
    }
}
