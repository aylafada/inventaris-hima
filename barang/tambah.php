<?php

require_once "../includes/koneksi.php";

$stmt = $pdo->query("
    SELECT *
    FROM kategori
    ORDER BY nama_kategori
");

$kategori = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang - Inventaris HIMA</title>
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
                <p class="eyebrow">Data Barang</p>
                <h1>Tambah Barang</h1>
                <p>Tambahkan barang baru ke inventaris HIMA.</p>
            </div>
        </div>

        <div class="form-card">

            <form action="/barang/proses_tambah.php" method="POST">

                <div class="form-group">
                    <label for="kode_barang">Kode Barang</label>
                    <input
                        type="text"
                        id="kode_barang"
                        name="kode_barang"
                        placeholder="Contoh: A001"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="nama_barang">Nama Barang</label>
                    <input
                        type="text"
                        id="nama_barang"
                        name="nama_barang"
                        placeholder="Contoh: Laptop"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="id_kategori">Kategori</label>

                    <select id="id_kategori" name="id_kategori" required>
                        <option value="">-- Pilih Kategori --</option>

                        <?php foreach ($kategori as $item): ?>

                            <option value="<?= $item['id_kategori'] ?>">
                                <?= htmlspecialchars($item['nama_kategori']) ?>
                            </option>

                        <?php endforeach; ?>

                    </select>
                </div>

                <div class="form-group">
                    <label for="jumlah">Jumlah</label>
                    <input
                        type="number"
                        id="jumlah"
                        name="jumlah"
                        min="0"
                        placeholder="Contoh: 5"
                        required
                    >
                </div>

                <div class="form-actions">

                    <a href="/barang/list.php" class="btn-secondary">
                        Batal
                    </a>

                    <button type="submit" class="btn-primary">
                        Simpan Barang
                    </button>

                </div>

            </form>

        </div>

    </main>

</div>

<script src="/assets/js/app.js"></script>
</body>
</html>