<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');


/*
|--------------------------------------------------------------------------
| JOBSHEET 8
|--------------------------------------------------------------------------
*/

if (strpos($uri, 'jobsheet8') === 0) {

    $jobsheetUri = substr($uri, strlen('jobsheet8'));
    $jobsheetUri = trim($jobsheetUri, '/');

    if ($jobsheetUri === '') {
        $jobsheetUri = 'index.php';
    }

    $_SERVER['REQUEST_URI'] = '/' . $jobsheetUri;

    require_once __DIR__ . '/../jobsheet8/api/index.php';

    exit;
}


/*
|--------------------------------------------------------------------------
| JOBSHEET 7
|--------------------------------------------------------------------------
*/

if (strpos($uri, 'jobsheet7') === 0) {

    $file = substr($uri, strlen('jobsheet7'));
    $file = trim($file, '/');

    if ($file === '') {
        $file = 'index.php';
    }

    $path = __DIR__ . '/../jobsheet7/' . $file;

    if (file_exists($path)) {
        require_once $path;
    } else {
        http_response_code(404);
        echo "404 - Halaman Jobsheet 7 Tidak Ditemukan";
    }

    exit;
}


/*
|--------------------------------------------------------------------------
| ASSETS ROOT
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
| HALAMAN TIDAK DITEMUKAN
|--------------------------------------------------------------------------
*/

http_response_code(404);

echo "404 - Halaman Tidak Ditemukan";