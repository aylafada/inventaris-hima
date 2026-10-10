<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

$id = get_id('id');   // integer positif atau null

if (!$id) {
    header('Location: ' . BASE_URL . '/anggota/list.php');
    exit;
}

$anggota = find_anggota($pdo, $id);

if (!$anggota) {
    abort_with('Data anggota tidak ditemukan.', 404);
}

$menuAktif = 'anggota';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Anggota - Inventaris HIMA</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>

<div class="layout">

    <?php require __DIR__ . '/../includes/sidebar.php'; ?>

    <main class="content">

        <div class="page-header">
            <div>
                <p class="eyebrow">Anggota</p>
                <h1>Edit Anggota</h1>
                <p>Perbarui data anggota HIMA.</p>
            </div>
        </div>

        <div class="form-card">
            <form action="<?= BASE_URL ?>/anggota/proses_edit.php" method="POST">
<?= csrf_field() ?>
                <input type="hidden" name="id_anggota" value="<?= (int) $anggota['id_anggota'] ?>">

                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input
                        type="text"
                        id="nim"
                        name="nim"
                        value="<?= e($anggota['nim']) ?>"
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
                        value="<?= e($anggota['nama']) ?>"
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
                        value="<?= e($anggota['no_hp'] ?? '') ?>"
                        maxlength="20"
                    >
                </div>

                <div class="form-actions">
                    <a href="<?= BASE_URL ?>/anggota/list.php" class="btn-secondary">Batal</a>
                    <button type="submit" class="btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>

    </main>

</div>

<script src="<?= BASE_URL ?>/assets/js/app.js"></script>

</body>
</html>
