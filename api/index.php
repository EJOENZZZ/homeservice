<?php

define('LARAVEL_START', microtime(true));

// Vercel is read-only except /tmp — create all needed dirs
if (!is_dir('/tmp/storage')) {
    $dirs = [
        '/tmp/storage/app/public',
        '/tmp/storage/framework/cache/data',
        '/tmp/storage/framework/sessions',
        '/tmp/storage/framework/views',
        '/tmp/storage/logs',
        '/tmp/bootstrap/cache',
    ];
    foreach ($dirs as $dir) {
        mkdir($dir, 0755, true);
    }
}

$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/../public/index.php';
$_SERVER['DOCUMENT_ROOT']   = __DIR__ . '/../public';

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Override storage and bootstrap/cache paths to /tmp
$app->useStoragePath('/tmp/storage');
$app->bootstrapPath('/tmp/bootstrap');

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
);

$response->send();

$kernel->terminate($request, $response);