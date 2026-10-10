<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

$id = get_id('id');   // integer positif atau null

if (!$id) {
    header('Location: ' . BASE_URL . '/barang/list.php');
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
    abort_with("Data barang tidak ditemukan.", 404);
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
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>

<body>

<div class="layout">

    <?php $menuAktif = 'barang'; require __DIR__ . '/../includes/sidebar.php'; ?>

    <main class="content">

        <div class="page-header">
            <div>
                <p class="eyebrow">Data Barang</p>
                <h1>Edit Barang</h1>
                <p>Perbarui informasi barang inventaris.</p>
            </div>
        </div>

        <div class="form-card">

            <form action="<?= BASE_URL ?>/barang/proses_edit.php" method="POST">
<?= csrf_field() ?>

                <input
                    type="hidden"
                    name="id_barang"
                    value="<?= e($barang['id_barang']) ?>"
                >

                <div class="form-group">
                    <label for="kode_barang">Kode Barang</label>
                    <input
                        type="text"
                        id="kode_barang"
                        name="kode_barang"
                        value="<?= e($barang['kode_barang']) ?>"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="nama_barang">Nama Barang</label>
                    <input
                        type="text"
                        id="nama_barang"
                        name="nama_barang"
                        value="<?= e($barang['nama_barang']) ?>"
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
                                value="<?= e($item['id_kategori']) ?>"
                                <?= $item['id_kategori'] == $barang['id_kategori'] ? 'selected' : '' ?>
                            >
                                <?= e($item['nama_kategori']) ?>
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
                        value="<?= e($barang['jumlah']) ?>"
                        required
                    >
                </div>

                <div class="form-actions">
                    <a href="<?= BASE_URL ?>/barang/list.php" class="btn-secondary">
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

<script src="<?= BASE_URL ?>/assets/js/app.js"></script>
</body>
</html>