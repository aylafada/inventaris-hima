<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

$id = get_id('id');   // integer positif atau null

if (!$id) {
    header('Location: ' . BASE_URL . '/peminjaman/list.php');
    exit;
}


/*
|--------------------------------------------------------------------------
| AMBIL DATA PEMINJAMAN
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT
        id_peminjaman,
        id_barang,
        nama_peminjam,
        tanggal_pinjam,
        status
    FROM peminjaman
    WHERE id_peminjaman = :id
");

$stmt->execute([
    ':id' => $id
]);

$peminjaman = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$peminjaman) {
    abort_with("Data peminjaman tidak ditemukan.", 404);
}


/*
|--------------------------------------------------------------------------
| AMBIL BARANG
|--------------------------------------------------------------------------
|
| Barang yang sedang dipakai tetap ditampilkan walaupun jumlah = 0.
|
*/

$stmtBarang = $pdo->prepare("
    SELECT
        id_barang,
        kode_barang,
        nama_barang,
        jumlah
    FROM barang
    WHERE jumlah > 0
       OR id_barang = :id_barang
    ORDER BY nama_barang
");

$stmtBarang->execute([
    ':id_barang' => $peminjaman['id_barang']
]);

$barang = $stmtBarang->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Peminjaman - Inventaris HIMA</title>

    <link
        rel="stylesheet"
        href="<?= BASE_URL ?>/assets/css/style.css"
    >

</head>

<body>

<div class="layout">

    <aside class="sidebar">

        <h2>Inventaris HIMA</h2>

        <p class="sidebar-subtitle">
            Sistem Inventaris
        </p>

        <nav>

            <a href="<?= BASE_URL ?>/index.php">
                Dashboard
            </a>

            <a href="<?= BASE_URL ?>/barang/list.php">
                Data Barang
            </a>

            <a
                href="<?= BASE_URL ?>/peminjaman/list.php"
                class="active"
            >
                Peminjaman
            </a>

        </nav>

    </aside>


    <main class="content">

        <div class="page-header">

            <div>

                <p class="eyebrow">
                    Peminjaman
                </p>

                <h1>
                    Edit Peminjaman
                </h1>

                <p>
                    Perbarui informasi peminjaman barang.
                </p>

            </div>

        </div>


        <div class="form-card">

            <form
                action="<?= BASE_URL ?>/peminjaman/proses_edit.php"
                method="POST"
            >
<?= csrf_field() ?>

                <input
                    type="hidden"
                    name="id_peminjaman"
                    value="<?= e($peminjaman['id_peminjaman']) ?>"
                >


                <div class="form-group">

                    <label for="id_barang">
                        Barang
                    </label>

                    <select
                        id="id_barang"
                        name="id_barang"
                        required
                    >

                        <?php foreach ($barang as $item): ?>

                            <option
                                value="<?= e($item['id_barang']) ?>"
                                <?= $item['id_barang'] == $peminjaman['id_barang']
                                    ? 'selected'
                                    : ''
                                ?>
                            >

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
                        value="<?= e($peminjaman['nama_peminjam']) ?>"
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
                        value="<?= e($peminjaman['tanggal_pinjam']) ?>"
                        required
                    >

                </div>


                <div class="form-actions">

                    <a
                        href="<?= BASE_URL ?>/peminjaman/list.php"
                        class="btn-secondary"
                    >
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="btn-primary"
                    >
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