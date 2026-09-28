<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');


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
| AUTH
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
| BARANG
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
| PEMINJAMAN
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

// =========================
// JOBSHEET 10
// =========================

if ($uri === 'jobsheet10' || $uri === 'jobsheet10/index.php') {
    require_once __DIR__ . '/../jobsheet10/index.php';
    exit;
}


http_response_code(404);
echo "404 - Halaman Tidak Ditemukan";