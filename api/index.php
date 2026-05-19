<?php

// Konfigurasi Khusus Vercel (Read-Only Filesystem)
// Arahkan semua cache, view, session, dan log ke folder /tmp yang diizinkan Vercel
putenv('VIEW_COMPILED_PATH=/tmp');
putenv('SESSION_DRIVER=cookie'); // Vercel tidak bisa pakai file session
putenv('LOG_CHANNEL=stderr');    // Vercel tidak bisa nulis ke laravel.log

$_ENV['VIEW_COMPILED_PATH'] = '/tmp';
$_ENV['SESSION_DRIVER'] = 'cookie';
$_ENV['LOG_CHANNEL'] = 'stderr';

// Tambahan untuk cache config Laravel
$_ENV['APP_CONFIG_CACHE'] = '/tmp/config.php';
$_ENV['APP_EVENTS_CACHE'] = '/tmp/events.php';
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/packages.php';
$_ENV['APP_ROUTES_CACHE'] = '/tmp/routes.php';
$_ENV['APP_SERVICES_CACHE'] = '/tmp/services.php';

require __DIR__ . '/../public/index.php';
