<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');


/*
|--------------------------------------------------------------------------
| JOBSHEET 10
|--------------------------------------------------------------------------
*/

if (strpos($uri, 'jobsheet11/') === 0 || $uri === 'jobsheet11') {

    $path = str_replace('jobsheet11/', '', $uri);

    /*
    |----------------------------------------------------------------------
    | Dashboard
    |----------------------------------------------------------------------
    */

    if ($path === '' || $path === 'index.php') {

        require_once __DIR__ . '/../jobsheet11/index.php';
        exit;
    }


    /*
    |----------------------------------------------------------------------
    | Assets
    |----------------------------------------------------------------------
    */

    if (strpos($path, 'assets/') === 0) {

        $filePath = __DIR__ . '/../jobsheet11/' . $path;

        if (file_exists($filePath)) {

            $ext = pathinfo($filePath, PATHINFO_EXTENSION);

            $mimeTypes = [
                'css' => 'text/css',
                'js' => 'application/javascript',
                'png' => 'image/png',
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'gif' => 'image/gif',
                'svg' => 'image/svg+xml',
                'ico' => 'image/x-icon'
            ];

            if (isset($mimeTypes[$ext])) {
                header('Content-Type: ' . $mimeTypes[$ext]);
            }

            readfile($filePath);
            exit;
        }
    }


    /*
    |----------------------------------------------------------------------
    | Auth
    |----------------------------------------------------------------------
    */

    if (strpos($path, 'auth/') === 0) {

        $file = str_replace('auth/', '', $path);

        $allowedFiles = [
            'login.php',
            'proses_login.php',
            'register.php',
            'proses_register.php',
            'logout.php'
        ];

        if (in_array($file, $allowedFiles)) {

            require_once __DIR__ . '/../jobsheet11/auth/' . $file;
            exit;
        }

        http_response_code(404);
        echo "404 - Halaman Auth Jobsheet 10 Tidak Ditemukan";
        exit;
    }


    /*
    |----------------------------------------------------------------------
    | Barang
    |----------------------------------------------------------------------
    */

    if (strpos($path, 'barang/') === 0) {

        $file = str_replace('barang/', '', $path);

        $allowedFiles = [
            'list.php',
            'tambah.php',
            'proses_tambah.php',
            'edit.php',
            'proses_edit.php',
            'hapus.php'
        ];

        if (in_array($file, $allowedFiles)) {

            require_once __DIR__ . '/../jobsheet11/barang/' . $file;
            exit;
        }

        http_response_code(404);
        echo "404 - Halaman Barang Jobsheet 10 Tidak Ditemukan";
        exit;
    }


    /*
    |----------------------------------------------------------------------
    | Peminjaman
    |----------------------------------------------------------------------
    */

    if (strpos($path, 'peminjaman/') === 0) {

        $file = str_replace('peminjaman/', '', $path);

        $allowedFiles = [
            'list.php',
            'tambah.php',
            'proses_tambah.php',
            'edit.php',
            'proses_edit.php',
            'kembalikan.php',
            'hapus.php'
        ];

        if (in_array($file, $allowedFiles)) {

            require_once __DIR__ . '/../jobsheet11/peminjaman/' . $file;
            exit;
        }

        http_response_code(404);
        echo "404 - Halaman Peminjaman Jobsheet 11 Tidak Ditemukan";
        exit;
    }


    http_response_code(404);
    echo "404 - Halaman Jobsheet 11 Tidak Ditemukan";
    exit;
}


/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

if ($uri === '' || $uri === 'index.php') {

    require_once __DIR__ . '/../index.php';
    exit;
}


/*
|--------------------------------------------------------------------------
| AUTH ROOT
|--------------------------------------------------------------------------
*/

if (strpos($uri, 'auth/') === 0 || $uri === 'auth') {

    $file = str_replace('auth/', '', $uri);

    if ($file === 'login.php') {

        require_once __DIR__ . '/../auth/login.php';

    } elseif ($file === 'proses_login.php') {

        require_once __DIR__ . '/../auth/proses_login.php';

    } elseif ($file === 'register.php') {

        require_once __DIR__ . '/../auth/register.php';

    } elseif ($file === 'proses_register.php') {

        require_once __DIR__ . '/../auth/proses_register.php';

    } elseif ($file === 'logout.php') {

        require_once __DIR__ . '/../auth/logout.php';

    } else {

        http_response_code(404);
        echo "404 - Halaman Auth Tidak Ditemukan";
    }

    exit;
}


/*
|--------------------------------------------------------------------------
| BARANG ROOT
|--------------------------------------------------------------------------
*/

if (strpos($uri, 'barang/') === 0 || $uri === 'barang') {

    $file = str_replace('barang/', '', $uri);

    if ($file === '' || $file === 'list.php') {

        require_once __DIR__ . '/../barang/list.php';

    } elseif ($file === 'tambah.php') {

        require_once __DIR__ . '/../barang/tambah.php';

    } elseif ($file === 'proses_tambah.php') {

        require_once __DIR__ . '/../barang/proses_tambah.php';

    } elseif ($file === 'edit.php') {

        require_once __DIR__ . '/../barang/edit.php';

    } elseif ($file === 'proses_edit.php') {

        require_once __DIR__ . '/../barang/proses_edit.php';

    } elseif ($file === 'hapus.php') {

        require_once __DIR__ . '/../barang/hapus.php';

    } else {

        http_response_code(404);
        echo "404 - Halaman Barang Tidak Ditemukan";
    }

    exit;
}


/*
|--------------------------------------------------------------------------
| PEMINJAMAN ROOT
|--------------------------------------------------------------------------
*/

if (strpos($uri, 'peminjaman/') === 0 || $uri === 'peminjaman') {

    $file = str_replace('peminjaman/', '', $uri);

    if ($file === '' || $file === 'list.php') {

        require_once __DIR__ . '/../peminjaman/list.php';

    } elseif ($file === 'tambah.php') {

        require_once __DIR__ . '/../peminjaman/tambah.php';

    } elseif ($file === 'proses_tambah.php') {

        require_once __DIR__ . '/../peminjaman/proses_tambah.php';

    } elseif ($file === 'edit.php') {

        require_once __DIR__ . '/../peminjaman/edit.php';

    } elseif ($file === 'proses_edit.php') {

        require_once __DIR__ . '/../peminjaman/proses_edit.php';

    } elseif ($file === 'kembalikan.php') {

        require_once __DIR__ . '/../peminjaman/kembalikan.php';

    } elseif ($file === 'hapus.php') {

        require_once __DIR__ . '/../peminjaman/hapus.php';

    } else {

        http_response_code(404);
        echo "404 - Halaman Peminjaman Tidak Ditemukan";
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


http_response_code(404);
echo "404 - Halaman Tidak Ditemukan";