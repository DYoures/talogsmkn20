<?php

/*
 * Vercel entrypoint for Laravel.
 *
 * Vercel's filesystem is read-only except for /tmp, so Laravel's storage
 * directory is moved to /tmp/storage (it is empty on every cold start, which is
 * fine for compiled views, cache and logs; uploaded files need external storage).
 */

$storage = '/tmp/storage';

foreach ([
    'app/public',
    'framework/cache/data',
    'framework/sessions',
    'framework/testing',
    'framework/views',
    'logs',
] as $directory) {
    if (! is_dir("{$storage}/{$directory}")) {
        mkdir("{$storage}/{$directory}", 0777, true);
    }
}

putenv("LARAVEL_STORAGE_PATH={$storage}");
$_ENV['LARAVEL_STORAGE_PATH'] = $storage;
$_SERVER['LARAVEL_STORAGE_PATH'] = $storage;

require __DIR__.'/../public/index.php';
