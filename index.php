<?php

require_once "includes/koneksi.php";

$totalBarang = $pdo->query("SELECT COUNT(*) FROM barang")->fetchColumn();

$totalStok = $pdo->query("SELECT COALESCE(SUM(jumlah), 0) FROM barang")->fetchColumn();

$totalDipinjam = $pdo->query(
    "SELECT COUNT(*) FROM peminjaman WHERE status = 'Dipinjam'"
)->fetchColumn();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris HIMA</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

<div class="layout">

    <aside class="sidebar">

        <h2>Inventaris HIMA</h2>

        <p class="sidebar-subtitle">
            Sistem Inventaris
        </p>

        <nav>
            <a href="index.php" class="active">Dashboard</a>
            <a href="barang/list.php">Data Barang</a>
            <a href="peminjaman/list.php">Peminjaman</a>
        </nav>

    </aside>


    <main class="content">

        <div class="page-header">
            <div>
                <p class="eyebrow">HIMA</p>
                <h1>Dashboard Inventaris</h1>
                <p>Kelola data barang dan peminjaman inventaris organisasi.</p>
            </div>
        </div>


        <section class="summary-grid">

            <div class="summary-card">
                <span>Total Barang</span>
                <strong><?= $totalBarang ?></strong>
            </div>

            <div class="summary-card">
                <span>Total Stok</span>
                <strong><?= $totalStok ?></strong>
            </div>

            <div class="summary-card">
                <span>Sedang Dipinjam</span>
                <strong><?= $totalDipinjam ?></strong>
            </div>

        </section>


        <section class="welcome-card">

            <div>
                <p class="eyebrow">Inventaris HIMA</p>

                <h2>
                    Kelola barang organisasi dengan lebih teratur.
                </h2>

                <p>
                    Gunakan menu di sebelah kiri untuk melihat data barang
                    atau mengelola peminjaman inventaris.
                </p>
            </div>

            <a href="barang/tambah.php" class="btn-primary">
                + Tambah Barang
            </a>

        </section>

    </main>

</div>

</body>
</html>