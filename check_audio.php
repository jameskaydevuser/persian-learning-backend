<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\ParentWordAudio;

$audio = ParentWordAudio::latest()->first();
if ($audio) {
    echo "Audio file path: " . $audio->audio_file_path . "\n";
    echo "File exists: " . (file_exists(storage_path('app/public/' . $audio->audio_file_path)) ? 'YES' : 'NO') . "\n";
    echo "Full path: " . storage_path('app/public/' . $audio->audio_file_path) . "\n";
} else {
    echo "No audio records found\n";
}
?>