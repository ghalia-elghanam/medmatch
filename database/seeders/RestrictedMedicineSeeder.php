<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestrictedMedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $restricted_medicines = [
            [
                'medicine_id' => 1,
                'restricted_medicine_id' => 2,
                'msg' => 'Rifampin can reduce the effectiveness of Warfarin, leading to clot risks',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 1,
                'restricted_medicine_id' => 9,
                'msg' => 'Can alter the effectiveness of Warfarin.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 1,
                'restricted_medicine_id' => 13,
                'msg' => 'Increased risk of bleeding',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 1,
                'restricted_medicine_id' => 14,
                'msg' => 'Increased risk of bleeding',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 1,
                'restricted_medicine_id' => 22,
                'msg' => 'Increased risk of gastrointestinal bleeding.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 3,
                'restricted_medicine_id' => 15,
                'msg' => 'Risk of serotonin syndrome, life-threatening.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 3,
                'restricted_medicine_id' => 16,
                'msg' => 'Risk of hypertensive crisis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 4,
                'restricted_medicine_id' => 17,
                'msg' => 'This combination can lead to an excess of serotonin in the brain, causing symptoms like agitation, confusion, rapid heart rate, sweating, muscle stiffness, and tremors.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 4,
                'restricted_medicine_id' => 18,
                'msg' => 'may increase the risk of serotonin syndrome with symptoms such as restlessness, hallucinations, and severe changes in blood pressure.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 5,
                'restricted_medicine_id' => 19,
                'msg' => 'Risk of hyperkalemia (high potassium)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 6,
                'restricted_medicine_id' => 20,
                'msg' => 'cause severe hypotension',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 7,
                'restricted_medicine_id' => 21,
                'msg' => 'Can cause severe bradycardia and heart block.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 8,
                'restricted_medicine_id' => 23,
                'msg' => 'Increased bleeding risk.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 10,
                'restricted_medicine_id' => 24,
                'msg' => 'Increased risk of muscle damage (rhabdomyolysis).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 11,
                'restricted_medicine_id' => 25,
                'msg' => 'Increased risk of sedation, respiratory depression, and overdose.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'medicine_id' => 12,
                'restricted_medicine_id' => 26,
                'msg' => 'Can cause severe drowsiness and respiratory depression.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        collect($restricted_medicines)->chunk(5)->each(function ($chunk) {
            DB::table('restricted_medicines')->insert($chunk->toArray());
        });
    }
}
