<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ParentUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test parent user
        User::updateOrCreate(
            ['email' => 'parent1@gmail.com'],
            [
                'name' => 'Parent1',
                'username' => 'parent1',
                'email' => 'parent1@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'parent',
                'parent_id' => null,
                'birth_date' => null,
                'avatar_color' => '#FF6B6B',
                'email_verified_at' => now(),
            ]
        );
        
        $this->command->info('Parent user created: parent1@gmail.com / password123');
    }
}
