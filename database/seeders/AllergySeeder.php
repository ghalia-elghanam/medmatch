<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AllergySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allergies = [
            [
                'name' => json_encode([
                    'en' => 'penicillin',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => json_encode([
                    'en' => 'voltaren',
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        collect($allergies)->chunk(5)->each(function ($chunk) {
            DB::table('allergies')->insert($chunk->toArray());
        });
    }
}
