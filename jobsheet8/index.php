<?php

require_once __DIR__ . '/includes/koneksi.php';

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
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

<div class="layout">

    <aside class="sidebar">

        <h2>Inventaris HIMA</h2>

        <p class="sidebar-subtitle">
            Sistem Inventaris
        </p>

        <nav>
            <a href="/" class="active">Dashboard</a>
            <a href="/barang/list.php">Data Barang</a>
            <a href="/peminjaman/list.php">Peminjaman</a>
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

            <a href="/barang/tambah.php" class="btn-primary">
                + Tambah Barang
            </a>

        </section>

                <section class="jobsheet-section">

            <div class="section-header">
                <div>
                    <p class="eyebrow">PROJECT JOURNEY</p>
                    <h2>Perkembangan Jobsheet</h2>
                    <p>
                        Perjalanan pengembangan project dari Jobsheet 1
                        hingga Jobsheet 8.
                    </p>
                </div>
            </div>

            <div class="jobsheet-grid">

                <div class="jobsheet-card">
                    <span class="jobsheet-number">01</span>
                    <div>
                        <p class="jobsheet-label">JOBSHEET 01</p>
                        <h3>HTML Dasar</h3>
                        <p>
                            Tahap awal pembuatan struktur halaman website.
                        </p>
                    </div>
                    <a
                        href="https://github.com/aylafada/DesainPemrogramanWeb/tree/main/jobsheet1"
                        target="_blank"
                        class="jobsheet-link"
                    >
                        Lihat Jobsheet →
                    </a>
                </div>

                <div class="jobsheet-card">
                    <span class="jobsheet-number">02</span>
                    <div>
                        <p class="jobsheet-label">JOBSHEET 02</p>
                        <h3>CSS</h3>
                        <p>
                            Pengembangan tampilan dan styling halaman website.
                        </p>
                    </div>
                    <a
                        href="https://github.com/aylafada/DesainPemrogramanWeb/tree/main/jobsheet2"
                        target="_blank"
                        class="jobsheet-link"
                    >
                        Lihat Jobsheet →
                    </a>
                </div>

                <div class="jobsheet-card">
                    <span class="jobsheet-number">03</span>
                    <div>
                        <p class="jobsheet-label">JOBSHEET 03</p>
                        <h3>Pengembangan Website</h3>
                        <p>
                            Pengembangan struktur dan tampilan project.
                        </p>
                    </div>
                    <a
                        href="https://github.com/aylafada/DesainPemrogramanWeb/tree/main/jobsheet3"
                        target="_blank"
                        class="jobsheet-link"
                    >
                        Lihat Jobsheet →
                    </a>
                </div>

                <div class="jobsheet-card">
                    <span class="jobsheet-number">04</span>
                    <div>
                        <p class="jobsheet-label">JOBSHEET 04</p>
                        <h3>Pengembangan Website</h3>
                        <p>
                            Project mulai dikembangkan dengan fitur yang lebih lengkap.
                        </p>
                    </div>
                    <a
                        href="https://github.com/aylafada/DesainPemrogramanWeb/tree/main/jobsheet4"
                        target="_blank"
                        class="jobsheet-link"
                    >
                        Lihat Jobsheet →
                    </a>
                </div>

                <div class="jobsheet-card">
                    <span class="jobsheet-number">05</span>
                    <div>
                        <p class="jobsheet-label">JOBSHEET 05</p>
                        <h3>JavaScript & DOM</h3>
                        <p>
                            Penambahan interaksi menggunakan JavaScript dan DOM.
                        </p>
                    </div>
                    <a
                        href="https://github.com/aylafada/DesainPemrogramanWeb/tree/main/jobsheet5"
                        target="_blank"
                        class="jobsheet-link"
                    >
                        Lihat Jobsheet →
                    </a>
                </div>

                <div class="jobsheet-card">
                    <span class="jobsheet-number">06</span>
                    <div>
                        <p class="jobsheet-label">JOBSHEET 06</p>
                        <h3>Fetch & JSON</h3>
                        <p>
                            Pengambilan dan pengolahan data menggunakan Fetch API.
                        </p>
                    </div>
                    <a
                        href="https://github.com/aylafada/DesainPemrogramanWeb/tree/main/jobsheet6"
                        target="_blank"
                        class="jobsheet-link"
                    >
                        Lihat Jobsheet →
                    </a>
                </div>

                <div class="jobsheet-card">
                    <span class="jobsheet-number">07</span>
                    <div>
                        <p class="jobsheet-label">JOBSHEET 07</p>
                        <h3>PHP</h3>
                        <p>
                            Project mulai dikembangkan menggunakan PHP.
                        </p>
                    </div>
                    <a
                        href="https://github.com/aylafada/DesainPemrogramanWeb/tree/main/jobsheet7"
                        target="_blank"
                        class="jobsheet-link"
                    >
                        Lihat Jobsheet →
                    </a>
                </div>

                <div class="jobsheet-card current">
                    <span class="jobsheet-number">08</span>
                    <div>
                        <p class="jobsheet-label">JOBSHEET 08 • CURRENT</p>
                        <h3>PHP + Database</h3>
                        <p>
                            Project terintegrasi dengan database dan fitur
                            pengelolaan data inventaris.
                        </p>
                    </div>
                    <a
                        href="/"
                        class="jobsheet-link"
                    >
                        Project Saat Ini →
                    </a>
                </div>

            </div>

        </section>

    </main>

</div>

<script src="/assets/js/app.js"></script>
</body>
</html>