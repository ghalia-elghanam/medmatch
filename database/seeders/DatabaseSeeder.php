<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $seeders = [
            RoleSeeder::class,
            MedicineSeeder::class,
            RestrictedMedicineSeeder::class,
            ComponentSeeder::class,
            MedicineComponentSeeder::class,
            UserSeeder::class,
            UserMedicineAllergySeeder::class,
            UserComponentAllergySeeder::class,
        ];
        foreach ($seeders as $seeder) {
            $this->call($seeder);
            $this->command->outputComponents()->success("{$seeder} run successfully!");
        }
    }
}
