<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserMedicineAllergySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user_allergy_medicine = [

            [
                'user_id' => 4,
                'user_allergy_medicine_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 4,
                'user_allergy_medicine_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'user_id' => 5,
                'user_allergy_medicine_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 5,
                'user_allergy_medicine_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];
        collect($user_allergy_medicine)->chunk(5)->each(function ($chunk) {
            DB::table('user_allergy_medicine')->insert($chunk->toArray());
        });
    }
}
