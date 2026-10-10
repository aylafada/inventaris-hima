<?php

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/koneksi.php';

$totalBarang = $pdo->query("
    SELECT COUNT(*)
    FROM barang
")->fetchColumn();

$totalStok = $pdo->query("
    SELECT COALESCE(SUM(jumlah), 0)
    FROM barang
")->fetchColumn();

$totalAnggota = $pdo->query("
    SELECT COUNT(*)
    FROM anggota
")->fetchColumn();

$totalDipinjam = $pdo->query("
    SELECT COUNT(*)
    FROM peminjaman
    WHERE status = 'Dipinjam'
")->fetchColumn();

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Inventaris HIMA - Jobsheet 12</title>

    <link
        rel="stylesheet"
        href="<?= BASE_URL ?>/assets/css/style.css"
    >

</head>

<body>

<div class="layout">

    <!-- SIDEBAR -->

    <?php $menuAktif = 'dashboard'; require __DIR__ . '/includes/sidebar.php'; ?>


    <!-- CONTENT -->

    <main class="content">

        <div class="page-header">

            <div>

                <p class="eyebrow">
                    HIMA
                </p>

                <h1>
                    Dashboard Inventaris
                </h1>

                <p>
                    Kelola data barang dan peminjaman inventaris organisasi.
                </p>

            </div>

        </div>


        <!-- SUMMARY -->

        <section class="summary-grid">

            <div class="summary-card">

                <span>
                    Total Barang
                </span>

                <strong>
                    <?= e($totalBarang) ?>
                </strong>

            </div>


            <div class="summary-card">

                <span>
                    Total Stok
                </span>

                <strong>
                    <?= e($totalStok) ?>
                </strong>

            </div>


            <div class="summary-card">

                <span>
                    Total Anggota
                </span>

                <strong>
                    <?= e($totalAnggota) ?>
                </strong>

            </div>


            <div class="summary-card">

                <span>
                    Sedang Dipinjam
                </span>

                <strong>
                    <?= e($totalDipinjam) ?>
                </strong>

            </div>

        </section>


        <!-- WELCOME -->

        <section class="welcome-card">

            <div>

                <p class="eyebrow">
                    Inventaris HIMA
                </p>

                <h2>
                    Kelola barang organisasi dengan lebih teratur.
                </h2>

                <p>
                    Gunakan menu di sebelah kiri untuk mengelola barang,
                    anggota, dan peminjaman inventaris.
                </p>

            </div>


            <a
                href="<?= BASE_URL ?>/barang/tambah.php"
                class="btn-primary"
            >
                + Tambah Barang
            </a>

        </section>

    </main>

</div>


<script src="<?= BASE_URL ?>/assets/js/app.js"></script>

</body>

</html>