<?php

$path = parse_url(
    $_SERVER['REQUEST_URI'] ?? '/',
    PHP_URL_PATH
);

$path = urldecode($path);

$basePath = dirname(__DIR__);


/*
|--------------------------------------------------------------------------
| STATIC FILE
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
| ROOT PORTFOLIO
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

    if (serveStaticFile($file)) {
        exit;
    }

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

    if (serveStaticFile($file)) {
        exit;
    }

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
| JOBSHEET 8 - LINK LAMA
|
| File JS8 masih memakai:
|
| /barang/...
| /peminjaman/...
|
| JANGAN REDIRECT!
| Langsung jalankan file aslinya
| supaya POST tetap terbawa.
|--------------------------------------------------------------------------
*/

$legacyRoutes = [
    '/barang' => '/jobsheet8/barang',
    '/peminjaman' => '/jobsheet8/peminjaman'
];

foreach ($legacyRoutes as $old => $new) {

    if (
        $path === $old ||
        str_starts_with($path, $old . '/')
    ) {

        $relativePath = substr(
            $path,
            strlen($old)
        );

        if (
            $relativePath === '' ||
            $relativePath === '/'
        ) {
            $relativePath = '/list.php';
        }

        $file =
            $basePath .
            $new .
            $relativePath;

        /*
        |------------------------------
        | PHP
        |------------------------------
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
        |------------------------------
        | Static
        |------------------------------
        */

        if (serveStaticFile($file)) {
            exit;
        }
    }
}


/*
|--------------------------------------------------------------------------
| ASSET LAMA JS8
|
| JS8 masih memakai:
|
| /assets/css/style.css
| /assets/js/app.js
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