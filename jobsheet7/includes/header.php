<?php

require_once __DIR__ . '/init.php';

$folderHalaman = basename(dirname($_SERVER['SCRIPT_FILENAME']));

if ($folderHalaman === 'buku' || $folderHalaman === 'anggota') {
    $base = '../';
} else {
    $base = '';
}
?>

<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="UTF=8">  
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>SIMPUS-Mini</title>

        <link rel="stylesheet" href="<?= $base ?>assets/css/style.css">
    </head>

    <body>
        <header>
            <h1>SIMPUS-Mini<h1>
            <button type="button" id="nav-toggle-btn" class="nav-toggle-label">
                &#9776;
            </button>
            <nav>
                <ul>
                    <li>
                        <a href="<?= $base ?>index.php">Beranda</a>
                    </li>

                    <li>
                        <a href="<?= $base ?>buku/list.php">Daftar Buku</a>
                    </li>

                    <li>
                        <a href="<?= $base ?>buku/tambah.php">Tambah Buku</a>
                    </li>

                    <li>
                        <a href="<?= $base ?>anggota/list.php">Daftar Anggota</a>
                    </li>

                    <li>
                        <a href="<?= $base ?>anggota/tambah.php">Tambah Anggota</a>
                    </li>
                </ul>
            </nav>
        </header>
    </body>