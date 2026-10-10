<?php

require_once __DIR__ . '/../includes/auth.php';

$menuAktif = 'anggota';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Anggota - Inventaris HIMA</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>

<div class="layout">

    <?php require __DIR__ . '/../includes/sidebar.php'; ?>

    <main class="content">

        <div class="page-header">
            <div>
                <p class="eyebrow">Anggota</p>
                <h1>Tambah Anggota</h1>
                <p>Daftarkan anggota HIMA yang boleh meminjam barang.</p>
            </div>
        </div>

        <div class="form-card">
            <form action="<?= BASE_URL ?>/anggota/proses_tambah.php" method="POST">
<?= csrf_field() ?>

                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input
                        type="text"
                        id="nim"
                        name="nim"
                        placeholder="Contoh: A0004"
                        maxlength="20"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        placeholder="Masukkan nama anggota"
                        maxlength="100"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="no_hp">No. HP (opsional)</label>
                    <input
                        type="text"
                        id="no_hp"
                        name="no_hp"
                        placeholder="Contoh: 081234567890"
                        maxlength="20"
                    >
                </div>

                <div class="form-actions">
                    <a href="<?= BASE_URL ?>/anggota/list.php" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary">Simpan Anggota</button>
                </div>
            </form>
        </div>

    </main>

</div>

<script src="<?= BASE_URL ?>/assets/js/app.js"></script>

</body>
</html>
