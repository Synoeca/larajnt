<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'admin123',
            'is_admin' => true
        ]);

        Profile::create([
            'first_name' => 'Admin',
            'last_name' => 'root',
            'phone' => 1234567899,
            'email' => 'jiwoo@jntcompany.com',
            'address1' => 'Roof Drive',
            'address2' => 'Jardine',
            'city' => 'Manhattan',
            'state' => 'KS',
            'zip' => 12345
        ]);
    }
}
