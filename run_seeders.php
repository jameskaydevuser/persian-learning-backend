<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Database\Seeders\CategorySeeder;
use Database\Seeders\WordSeeder;

echo "Running seeders...\n";

try {
    $categorySeeder = new CategorySeeder();
    $categorySeeder->run();
    echo "Categories seeded successfully!\n";
    
    $wordSeeder = new WordSeeder();
    $wordSeeder->run();
    echo "Words seeded successfully!\n";
    
    echo "All seeders completed!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
