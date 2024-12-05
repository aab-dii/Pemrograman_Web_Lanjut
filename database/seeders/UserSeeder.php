<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'role' => 'admin',
                'email' => 'admin@mail.com',
                'password' => Hash::make('123456789'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Karyawan User',
                'role' => 'karyawan',
                'email' => 'karyawan@mail.com',
                'password' => Hash::make('123456789'),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    // /**
    //  * Run the database seeds.
    //  */
    // public function run(): void
    // {
    //     //
    // }
}
