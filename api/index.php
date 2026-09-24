<?php

$path = parse_url(
    $_SERVER['REQUEST_URI'] ?? '/',
    PHP_URL_PATH
);

$path = urldecode($path);

$basePath = dirname(__DIR__);


/*
|--------------------------------------------------------------------------
| SERVE STATIC FILE
|--------------------------------------------------------------------------
*/

function serveStaticFile($file)
{
    if (!is_file($file)) {
        return false;
    }

    $extension = strtolower(
        pathinfo($file, PATHINFO_EXTENSION)
    );

    $mimeTypes = [
        'html'  => 'text/html; charset=UTF-8',
        'css'   => 'text/css; charset=UTF-8',
        'js'    => 'application/javascript; charset=UTF-8',

        'png'   => 'image/png',
        'jpg'   => 'image/jpeg',
        'jpeg'  => 'image/jpeg',
        'gif'   => 'image/gif',
        'svg'   => 'image/svg+xml',
        'webp'  => 'image/webp',
        'ico'   => 'image/x-icon',

        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf'
    ];

    if (!isset($mimeTypes[$extension])) {
        return false;
    }

    header(
        'Content-Type: ' .
        $mimeTypes[$extension]
    );

    readfile($file);

    exit;
}


/*
|--------------------------------------------------------------------------
| ROOT WEBSITE
|--------------------------------------------------------------------------
*/

if ($path === '/' || $path === '') {

    $file = $basePath . '/index.html';

    if (is_file($file)) {

        header(
            'Content-Type: text/html; charset=UTF-8'
        );

        readfile($file);

        exit;
    }
}


/*
|--------------------------------------------------------------------------
| JOBSHEET 7
|--------------------------------------------------------------------------
*/

if (
    $path === '/jobsheet7' ||
    str_starts_with($path, '/jobsheet7/')
) {

    $relativePath = substr(
        $path,
        strlen('/jobsheet7')
    );

    if (
        $relativePath === '' ||
        $relativePath === '/'
    ) {
        $relativePath = '/index.php';
    }

    $file =
        $basePath .
        '/jobsheet7' .
        $relativePath;


    /*
    | Static files
    */

    if (serveStaticFile($file)) {
        exit;
    }


    /*
    | PHP
    */

    if (
        strtolower(
            pathinfo($file, PATHINFO_EXTENSION)
        ) === 'php' &&
        is_file($file)
    ) {
        require $file;
        exit;
    }
}


/*
|--------------------------------------------------------------------------
| JOBSHEET 8
|--------------------------------------------------------------------------
*/

if (
    $path === '/jobsheet8' ||
    str_starts_with($path, '/jobsheet8/')
) {

    $relativePath = substr(
        $path,
        strlen('/jobsheet8')
    );

    if (
        $relativePath === '' ||
        $relativePath === '/'
    ) {
        $relativePath = '/index.php';
    }

    $file =
        $basePath .
        '/jobsheet8' .
        $relativePath;


    /*
    | Static files
    */

    if (serveStaticFile($file)) {
        exit;
    }


    /*
    | PHP
    */

    if (
        strtolower(
            pathinfo($file, PATHINFO_EXTENSION)
        ) === 'php' &&
        is_file($file)
    ) {
        require $file;
        exit;
    }
}


/*
|--------------------------------------------------------------------------
| COMPATIBILITY UNTUK LINK LAMA JOBSHEET 8
|--------------------------------------------------------------------------
|
| JS8 lama masih menggunakan:
| /barang/...
| /peminjaman/...
|
| Kita arahkan ke folder jobsheet8.
|
|--------------------------------------------------------------------------
*/

if (
    $path === '/barang' ||
    str_starts_with($path, '/barang/')
) {

    $newPath =
        '/jobsheet8' .
        $path;

    header(
        'Location: ' . $newPath,
        true,
        302
    );

    exit;
}


if (
    $path === '/peminjaman' ||
    str_starts_with($path, '/peminjaman/')
) {

    $newPath =
        '/jobsheet8' .
        $path;

    header(
        'Location: ' . $newPath,
        true,
        302
    );

    exit;
}


/*
|--------------------------------------------------------------------------
| KOMPATIBILITAS ASSET LAMA JOBSHEET 8
|--------------------------------------------------------------------------
|
| JS8 lama masih menggunakan:
| /assets/css/style.css
| /assets/js/app.js
|
|--------------------------------------------------------------------------
*/

if (
    $path === '/assets' ||
    str_starts_with($path, '/assets/')
) {

    $relativeAsset = substr(
        $path,
        strlen('/assets')
    );

    $file =
        $basePath .
        '/jobsheet8/assets' .
        $relativeAsset;

    if (serveStaticFile($file)) {
        exit;
    }
}


/*
|--------------------------------------------------------------------------
| ROOT STATIC FILE
|--------------------------------------------------------------------------
*/

$file =
    $basePath .
    $path;

if (serveStaticFile($file)) {
    exit;
}


/*
|--------------------------------------------------------------------------
| ROOT PHP
|--------------------------------------------------------------------------
*/

if (
    strtolower(
        pathinfo($file, PATHINFO_EXTENSION)
    ) === 'php' &&
    is_file($file)
) {
    require $file;
    exit;
}


/*
|--------------------------------------------------------------------------
| 404
|--------------------------------------------------------------------------
*/

http_response_code(404);

echo "404 - Halaman tidak ditemukan.";