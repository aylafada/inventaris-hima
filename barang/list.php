<?php

require_once "../includes/koneksi.php";

$sql = "
    SELECT
        b.id_barang,
        b.kode_barang,
        b.nama_barang,
        k.nama_kategori,
        b.jumlah
    FROM barang b
    JOIN kategori k
        ON b.id_kategori = k.id_kategori
    ORDER BY b.id_barang DESC
";

$stmt = $pdo->query($sql);
$barang = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang - Inventaris HIMA</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

<div class="layout">

    <aside class="sidebar">
        <h2>Inventaris HIMA</h2>
        <p class="sidebar-subtitle">Sistem Inventaris</p>

        <nav>
            <a href="/">Dashboard</a>
            <a href="/barang/list.php" class="active">Data Barang</a>
            <a href="/peminjaman/list.php">Peminjaman</a>
        </nav>
    </aside>

    <main class="content">

        <div class="page-header">

            <div>
                <p class="eyebrow">Inventaris</p>
                <h1>Data Barang</h1>
                <p>Daftar barang yang dimiliki oleh HIMA.</p>
            </div>

            <a href="/barang/tambah.php" class="btn-primary">
                + Tambah Barang
            </a>

        </div>

        <?php if (count($barang) > 0): ?>

            <div class="barang-grid">

                <?php foreach ($barang as $item): ?>

                    <div class="barang-card">

                        <div class="barang-info">

                            <span class="barang-code">
                                <?= htmlspecialchars($item['kode_barang']) ?>
                            </span>

                            <h3>
                                <?= htmlspecialchars($item['nama_barang']) ?>
                            </h3>

                            <p>
                                <?= htmlspecialchars($item['nama_kategori']) ?>
                            </p>

                            <div class="barang-stock">
                                <span>Jumlah</span>
                                <strong>
                                    <?= $item['jumlah'] ?>
                                </strong>
                            </div>

                        </div>

                        <div class="card-actions">

                            <a
                                href="/barang/edit.php?id=<?= $item['id_barang'] ?>"
                                class="btn-small"
                            >
                                Edit
                            </a>

                            <a
                                href="/barang/hapus.php?id=<?= $item['id_barang'] ?>"
                                class="btn-small danger"
                                onclick="return confirm('Yakin ingin menghapus barang ini?')"
                            >
                                Hapus
                            </a>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <div class="empty-state">
                <h3>Belum ada barang</h3>
                <p>Tambahkan barang pertama ke inventaris HIMA.</p>

                <a href="/barang/tambah.php" class="btn-primary">
                    + Tambah Barang
                </a>
            </div>

        <?php endif; ?>

    </main>

</div>

<script src="/assets/js/app.js"></script>
</body>
</html>