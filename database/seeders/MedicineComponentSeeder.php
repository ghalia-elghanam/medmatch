<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicineComponentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $med_comp = [
            [
                'medicine_id' => 1,
                'component_id' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 1,
                'component_id' => 13,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 1,
                'component_id' => 17,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 2,
                'component_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 2,
                'component_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 2,
                'component_id' => 13,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 2,
                'component_id' => 14,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 2,
                'component_id' => 17,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 3,
                'component_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 3,
                'component_id' => 16,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 3,
                'component_id' => 17,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 4, //
                'component_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 4,
                'component_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 4,
                'component_id' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 4,
                'component_id' => 17,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 4,
                'component_id' => 18,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 5,
                'component_id' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 5,
                'component_id' => 13,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 5,
                'component_id' => 14,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 5,
                'component_id' => 17,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 6,
                'component_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 6,
                'component_id' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 6,
                'component_id' => 16,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 6,
                'component_id' => 17,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 7,
                'component_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 7,
                'component_id' => 13,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 7,
                'component_id' => 14,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 7,
                'component_id' => 17,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 8,
                'component_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 8,
                'component_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 8,
                'component_id' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 17,
                'component_id' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 18,
                'component_id' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 19,
                'component_id' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 20,
                'component_id' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 22,
                'component_id' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 22,
                'component_id' => 13,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 22,
                'component_id' => 14,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 22,
                'component_id' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 22,
                'component_id' => 17,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 23,
                'component_id' => 16,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 23,
                'component_id' => 17,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 23,
                'component_id' => 18,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 23,
                'component_id' => 19,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        collect($med_comp)->chunk(5)->each(function ($chunk) {
            DB::table('medicine_component')->insert($chunk->toArray());
        });
    }
}
