<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User; // Make sure to import the User model

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if the admin user already exists to avoid duplicates
        if (!User::where('email', 'admin@gamil.com')->exists()) {
            User::create([
                'name' => 'Admin User',
                'email' => 'admin@gamil.com',
                'phone'=>'03432436123',
                'password' => bcrypt('123'), // Make sure to hash the password
                'role' => 'admin', // Assuming you have a role column in your users table
            ]);
        }
    }
}
