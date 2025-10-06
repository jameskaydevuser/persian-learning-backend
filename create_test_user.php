<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Create a test parent user
$user = User::create([
    'name' => 'Test Parent',
    'email' => 'parent1@gmail.com',
    'username' => 'parent1',
    'password' => Hash::make('12345678'),
    'role' => 'parent',
    'email_verified_at' => now(),
]);

echo "User created successfully!\n";
echo "Email: parent1@gmail.com\n";
echo "Username: parent1\n";
echo "Password: 12345678\n";
echo "Role: parent\n";
