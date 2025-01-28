<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => env('ADMIN_USERNAME'), // Use username instead of name
            'email' => env('ADMIN_EMAIL'), // Default admin email
            'password' => Hash::make(env('ADMIN_PASSWORD')), // Hash the password
            'country' => null, // Admins do not have a country
            'role' => 'admin', // Set the role to 'admin'
        ]);
    }
}
