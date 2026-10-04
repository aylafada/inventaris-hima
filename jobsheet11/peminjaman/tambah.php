<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

$stmt = $pdo->query("
    SELECT
        b.id_barang,
        b.kode_barang,
        b.nama_barang,
        b.jumlah
    FROM barang b
    WHERE b.jumlah > 0
    ORDER BY b.nama_barang
");

$barang = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Peminjaman - Inventaris HIMA</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>
<div class="layout">
    <aside class="sidebar">
        <h2>Inventaris HIMA</h2>
        <p class="sidebar-subtitle">Sistem Inventaris</p>
        <nav>
            <a href="<?= BASE_URL ?>/index.php">Dashboard</a>
            <a href="<?= BASE_URL ?>/barang/list.php">Data Barang</a>
            <a href="<?= BASE_URL ?>/peminjaman/list.php" class="active">Peminjaman</a>
        </nav>
    </aside>
    <main class="content">
        <div class="page-header">
            <div>
                <p class="eyebrow">Peminjaman</p>
                <h1>Tambah Peminjaman</h1>
                <p>Catat peminjaman barang inventaris HIMA.</p>
            </div>
        </div>
        <div class="form-card">
            <?php if (count($barang) > 0): ?>
                <form action="<?= BASE_URL ?>/peminjaman/proses_tambah.php" method="POST">
<?= csrf_field() ?>
                    <div class="form-group">
                        <label for="id_barang">
                            Barang
                        </label>
                        <select
                            id="id_barang"
                            name="id_barang"
                            required
                        >
                            <option value="">
                                -- Pilih Barang --
                            </option>
                            <?php foreach ($barang as $item): ?>

                                <option value="<?= e($item['id_barang']) ?>">
                                    <?= e($item['kode_barang']) ?>
                                    -
                                    <?= e($item['nama_barang']) ?>
                                    (Stok: <?= e($item['jumlah']) ?>)
                                </option>

                            <?php endforeach; ?>

                        </select>

                    </div>

                    <div class="form-group">

                        <label for="nama_peminjam">
                            Nama Peminjam
                        </label>

                        <input
                            type="text"
                            id="nama_peminjam"
                            name="nama_peminjam"
                            placeholder="Masukkan nama peminjam"
                            required
                        >

                    </div>

                    <div class="form-group">

                        <label for="tanggal_pinjam">
                            Tanggal Pinjam
                        </label>

                        <input
                            type="date"
                            id="tanggal_pinjam"
                            name="tanggal_pinjam"
                            value="<?= date('Y-m-d') ?>"
                            required
                        >

                    </div>

                    <div class="form-actions">

                        <a href="<?= BASE_URL ?>/peminjaman/list.php" class="btn-secondary">
                            Batal
                        </a>

                        <button
                            type="submit"
                            class="btn-primary"
                        >
                            Simpan Peminjaman
                        </button>

                    </div>

                </form>

            <?php else: ?>

                <div class="empty-state">

                    <h3>Belum ada barang tersedia</h3>

                    <p>
                        Tambahkan barang dengan jumlah lebih dari 0
                        sebelum membuat peminjaman.
                    </p>

                    <a
                        href="<?= BASE_URL ?>/barang/tambah.php"
                        class="btn-primary"
                    >
                        + Tambah Barang
                    </a>

                </div>

            <?php endif; ?>

        </div>

    </main>

</div>

<script src="<?= BASE_URL ?>/assets/js/app.js"></script>
</body>
</html>