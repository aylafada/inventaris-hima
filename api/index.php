```php
<?php

// Ambil path request dari URL
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');


/*
|--------------------------------------------------------------------------
| ROUTING JOBSHEET 8
|--------------------------------------------------------------------------
*/

if (strpos($uri, 'jobsheet8') === 0) {

    // Hilangkan "jobsheet8" dari URL
    $jobsheetUri = substr($uri, strlen('jobsheet8'));
    $jobsheetUri = trim($jobsheetUri, '/');

    // Simpan REQUEST_URI asli
    $originalUri = $_SERVER['REQUEST_URI'];

    // Jika hanya membuka /jobsheet8,
    // arahkan ke index.php
    if ($jobsheetUri === '') {
        $jobsheetUri = 'index.php';
    }

    // Berikan path yang sesuai ke router Jobsheet 8
    $_SERVER['REQUEST_URI'] = '/' . $jobsheetUri;

    require_once __DIR__ . '/../jobsheet8/api/index.php';

    // Kembalikan REQUEST_URI
    $_SERVER['REQUEST_URI'] = $originalUri;

    exit;
}


/*
|--------------------------------------------------------------------------
| ROOT LANDING PAGE
|--------------------------------------------------------------------------
*/

if ($uri === '' || $uri === 'index.php') {

    require_once __DIR__ . '/../index.html';

    exit;
}


/*
|--------------------------------------------------------------------------
| JOBSHEET 7
|--------------------------------------------------------------------------
*/

if (strpos($uri, 'jobsheet7/') === 0 || $uri === 'jobsheet7') {

    $file = str_replace('jobsheet7/', '', $uri);

    if ($file === '' || $file === 'index.php') {

        require_once __DIR__ . '/../jobsheet7/index.php';

    } else {

        $path = __DIR__ . '/../jobsheet7/' . $file;

        if (file_exists($path)) {

            require_once $path;

        } else {

            http_response_code(404);
            echo "404 - Halaman Jobsheet 7 Tidak Ditemukan";

        }

    }

    exit;
}


/*
|--------------------------------------------------------------------------
| ASSETS
|--------------------------------------------------------------------------
*/

if (strpos($uri, 'assets/') === 0) {

    $assetPath = __DIR__ . '/../' . $uri;

    if (file_exists($assetPath)) {

        $ext = pathinfo($assetPath, PATHINFO_EXTENSION);

        $mimeTypes = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'ico' => 'image/x-icon'
        ];

        if (isset($mimeTypes[$ext])) {
            header('Content-Type: ' . $mimeTypes[$ext]);
        }

        readfile($assetPath);

        exit;
    }
}


/*
|--------------------------------------------------------------------------
| ROUTE TIDAK DITEMUKAN
|--------------------------------------------------------------------------
*/

http_response_code(404);

echo "404 - Halaman Tidak Ditemukan";