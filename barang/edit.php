<?php

require_once "../includes/koneksi.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: /barang/list.php");
    exit;
}

$stmt = $pdo->prepare("
    SELECT *
    FROM barang
    WHERE id_barang = :id
");

$stmt->execute([
    ':id' => $id
]);

$barang = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$barang) {
    die("Data barang tidak ditemukan.");
}

$stmtKategori = $pdo->query("
    SELECT *
    FROM kategori
    ORDER BY nama_kategori
");

$kategori = $stmtKategori->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang - Inventaris HIMA</title>
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
                <h1>Edit Barang</h1>
                <p>Perbarui informasi barang inventaris.</p>
            </div>
        </div>

        <div class="form-card">

            <form action="/barang/proses_edit.php" method="POST">

                <input
                    type="hidden"
                    name="id_barang"
                    value="<?= $barang['id_barang'] ?>"
                >

                <div class="form-group">
                    <label for="kode_barang">Kode Barang</label>
                    <input
                        type="text"
                        id="kode_barang"
                        name="kode_barang"
                        value="<?= htmlspecialchars($barang['kode_barang']) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="nama_barang">Nama Barang</label>
                    <input
                        type="text"
                        id="nama_barang"
                        name="nama_barang"
                        value="<?= htmlspecialchars($barang['nama_barang']) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="id_kategori">Kategori</label>
                    <select
                        id="id_kategori"
                        name="id_kategori"
                        required
                    >
                        <?php foreach ($kategori as $item): ?>
                            <option
                                value="<?= $item['id_kategori'] ?>"
                                <?= $item['id_kategori'] == $barang['id_kategori'] ? 'selected' : '' ?>
                            >
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
                        value="<?= $barang['jumlah'] ?>"
                        required
                    >
                </div>

                <div class="form-actions">
                    <a href="/barang/list.php" class="btn-secondary">
                        Batal
                    </a>
                    <button type="submit" class="btn-primary">
                        Simpan Perubahan
                    </button>
                </div>

            </form>

        </div>

    </main>

</div>

<script src="/assets/js/app.js"></script>
</body>
</html>