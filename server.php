<?php

/**
 * Laravel development server router.
 *
 * This file allows the built-in PHP server (used by `php artisan serve`)
 * to serve static files such as images, CSS, JS, MP3, etc.
 * If the requested file exists in the /public directory, it will be served
 * directly. Otherwise, Laravel’s front controller (index.php) handles it.
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// If the requested file exists in the public directory, serve it directly.
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

// Otherwise, let Laravel handle the request.
require_once __DIR__ . '/public/index.php';
