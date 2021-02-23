<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'position' => 'System App',
            'department_id' => 1,
            'email_verified_at' => now(),
            'password' => 'admin123',
            'status' => true,
            'created_at' => now()
        ]);
    }
}
