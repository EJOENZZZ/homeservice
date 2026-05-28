<?php

define('LARAVEL_START', microtime(true));

// Create writable dirs in /tmp
$tmpDirs = [
    '/tmp/storage/app/public',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
];
foreach ($tmpDirs as $dir) {
    if (!is_dir($dir)) mkdir($dir, 0755, true);
}

// Copy bootstrap/cache files to /tmp if needed
$bootstrapCache = __DIR__ . '/../bootstrap/cache';
foreach (glob($bootstrapCache . '/*.php') as $file) {
    $dest = '/tmp/bootstrap/cache/' . basename($file);
    if (!file_exists($dest)) copy($file, $dest);
}

$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/../public/index.php';
$_SERVER['DOCUMENT_ROOT']   = __DIR__ . '/../public';

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$app->useStoragePath('/tmp/storage');

// Override PackageManifest to use /tmp
$app->instance(\Illuminate\Foundation\PackageManifest::class,
    new \Illuminate\Foundation\PackageManifest(
        new \Illuminate\Filesystem\Filesystem,
        $app->basePath(),
        '/tmp/bootstrap/cache/packages.php'
    )
);

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
);

$response->send();

$kernel->terminate($request, $response);