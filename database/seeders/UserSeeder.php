<?php

namespace Database\Seeders;

use App\Enums\GenderType;
use App\Enums\RoleType;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //############ Admin #############
        User::query()->updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('0000000000'),
                'ssn' => '0000000000',
                'birth' => '01/01/1950',
                'gender' => GenderType::male->value,
                'phone' => '0000000000',
                'address' => 'Amman',
                'email_verified_at' => now(),
            ]
        )->assignRole(RoleType::admin->value);
        //############ Admin #############

        //############ Doctor #############
        User::query()->updateOrCreate(
            ['email' => 'doctor@gmail.com'],
            [
                'name' => 'Doctor',
                'email' => 'doctor@gmail.com',
                'password' => bcrypt('doctor@gmail.com'),
                'ssn' => '9638527415',
                'birth' => '01/01/1950',
                'gender' => GenderType::male->value,
                'phone' => '9638527415',
                'address' => 'Amman',
                'email_verified_at' => now(),
            ]
        )->assignRole(RoleType::doctor->value);
        //############ Doctor #############

        //############ Radiologist #############
        User::query()->updateOrCreate(
            ['email' => 'radiologist@gmail.com'],
            [
                'name' => 'Radiologist',
                'email' => 'radiologist@gmail.com',
                'password' => bcrypt('radiologist@gmail.com'),
                'ssn' => '1593578235',
                'birth' => '01/01/1950',
                'gender' => GenderType::male->value,
                'phone' => '1593578235',
                'address' => 'Amman',
                'email_verified_at' => now(),
            ]
        )->assignRole(RoleType::radiologist->value);
        //############ Radiologist #############

        //############ Patients #############
        // 1
        User::query()->updateOrCreate(
            ['email' => 'yousef.jabr@gmail.com'],
            [
                'name' => 'Yousef Jabr',
                'email' => 'yousef.jabr@gmail.com',
                'email_verified_at' => now(),
                'ssn' => 'MR001',
                'result' => 'test result one',
                'birth' => '12/05/1977',
                'gender' => GenderType::male->value,
                'phone' => '0790464663',
                'address' => 'Amman',
            ]
        )->assignRole(RoleType::patient->value);
        // 2
        User::query()->updateOrCreate(
            ['email' => 'sumaya.ayad@gmail.com'],
            [
                'name' => 'Sumaya Ayad',
                'email' => 'sumaya.ayad@gmail.com',
                'email_verified_at' => now(),
                'ssn' => 'MR002',
                'result' => 'test result two',
                'birth' => '15/07/1990',
                'gender' => GenderType::female->value,
                'phone' => '0786235575',
                'address' => 'Irbid',
            ]
        )->assignRole(RoleType::patient->value);
        // 3
        User::query()->updateOrCreate(
            ['email' => 'marah.aldaqa@gmail.com'],
            [
                'name' => 'Marah Aldaqa',
                'email' => 'marah.aldaqa@gmail.com',
                'email_verified_at' => now(),
                'ssn' => 'MR003',
                'result' => 'test result three',
                'birth' => '22/09/1975',
                'gender' => GenderType::female->value,
                'phone' => '0796180506',
                'address' => 'Amman',
            ]
        )->assignRole(RoleType::patient->value);
        // 4
        User::query()->updateOrCreate(
            ['email' => 'khalid.aleimran@gmail.com'],
            [
                'name' => 'khalid Aleimran',
                'email' => 'khalid.aleimran@gmail.com',
                'email_verified_at' => now(),
                'ssn' => 'MR004',
                'result' => 'test result four',
                'birth' => '05/11/1985',
                'gender' => GenderType::male->value,
                'phone' => '0795616294',
                'address' => 'Amman',
            ]
        )->assignRole(RoleType::patient->value);
        // 5
        User::query()->updateOrCreate(
            ['email' => 'nada.azzam@gmail.com'],
            [
                'name' => 'Nada Azzam',
                'email' => 'nada.azzam@gmail.com',
                'email_verified_at' => now(),
                'ssn' => 'MR005',
                'result' => 'test result five',
                'birth' => '18/02/2000',
                'gender' => GenderType::female->value,
                'phone' => '0796518846',
                'address' => 'Jerash',
            ]
        )->assignRole(RoleType::patient->value);
        //############ Patients #############


        //############ receptionist #############
        User::query()->updateOrCreate(
            ['email' => 'receptionist@gmail.com'],
            [
                'name' => 'Receptionist',
                'email' => 'receptionist@gmail.com',
                'password' => bcrypt('receptionist@gmail.com'),
                'ssn' => '5556662221',
                'birth' => '01/01/1950',
                'gender' => GenderType::male->value,
                'phone' => '5556662221',
                'address' => 'Amman',
                'email_verified_at' => now(),
            ]
        )->assignRole(RoleType::receptionist->value);
        //############ receptionist #############
    }
}
