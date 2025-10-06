<?php
// Simple test to check if audio files exist
$audioDir = __DIR__ . '/storage/app/public/parent_audio/';
$files = glob($audioDir . '*.mp3');

echo "Audio files found:\n";
foreach ($files as $file) {
    $filename = basename($file);
    echo "- $filename\n";
    echo "  Size: " . filesize($file) . " bytes\n";
    echo "  URL: http://10.0.2.2:8000/api/audio/$filename\n";
    echo "  Storage URL: http://10.0.2.2:8000/storage/parent_audio/$filename\n";
    echo "\n";
}
?>
