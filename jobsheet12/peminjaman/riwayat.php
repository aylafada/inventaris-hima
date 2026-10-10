<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

/* Pilihan anggota untuk filter */
$daftarAnggota = $pdo->query('SELECT id_anggota, nim, nama FROM anggota ORDER BY nama')
    ->fetchAll(PDO::FETCH_ASSOC);

$idAnggota = get_id('id_anggota');   // integer positif atau null
$anggota   = null;
$ringkasan = null;

if ($idAnggota !== null) {

    $anggota = find_anggota($pdo, $idAnggota);

    if (!$anggota) {
        abort_with('Anggota tidak ditemukan.', 404);
    }

    $stmt = $pdo->prepare('
        SELECT
            COUNT(*) AS total,
            COUNT(*) FILTER (WHERE p.status = \'Dipinjam\') AS aktif,
            COUNT(*) FILTER (WHERE ' . sql_terlambat('p') . ') AS terlambat
        FROM peminjaman p
        WHERE p.id_anggota = :id
    ');
    $stmt->execute([':id' => $idAnggota]);
    $ringkasan = $stmt->fetch(PDO::FETCH_ASSOC);
}

/* RIWAYAT: JOIN 3 tabel (peminjaman + barang + anggota) */
$sql = '
    SELECT
        p.id_peminjaman,
        p.tanggal_pinjam,
        p.tanggal_kembali,
        p.status,
        (CURRENT_DATE - p.tanggal_pinjam) AS lama_hari,
        ' . sql_terlambat('p') . ' AS terlambat,
        b.kode_barang,
        b.nama_barang,
        a.id_anggota,
        a.nim,
        a.nama AS nama_anggota
    FROM peminjaman p
    JOIN barang  b ON p.id_barang  = b.id_barang
    JOIN anggota a ON p.id_anggota = a.id_anggota
';

if ($idAnggota !== null) {
    $stmt = $pdo->prepare($sql . ' WHERE a.id_anggota = :id ORDER BY p.tanggal_pinjam DESC, p.id_peminjaman DESC LIMIT 100');
    $stmt->execute([':id' => $idAnggota]);
} else {
    $stmt = $pdo->prepare($sql . ' ORDER BY p.tanggal_pinjam DESC, p.id_peminjaman DESC LIMIT 100');
    $stmt->execute();
}

$riwayat = $stmt->fetchAll(PDO::FETCH_ASSOC);

$menuAktif = 'riwayat';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - Inventaris HIMA</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>

<div class="layout">

    <?php require __DIR__ . '/../includes/sidebar.php'; ?>

    <main class="content">

        <div class="page-header">
            <div>
                <p class="eyebrow">PEMINJAMAN</p>
                <h1>Riwayat Peminjaman</h1>
                <p>
                    <?php if ($anggota): ?>
                        Histori peminjaman <?= e($anggota['nama']) ?> (<?= e($anggota['nim']) ?>).
                    <?php else: ?>
                        Pilih anggota untuk melihat riwayat per anggota, atau lihat seluruh riwayat terbaru.
                    <?php endif; ?>
                </p>
            </div>

            <a href="<?= BASE_URL ?>/peminjaman/list.php" class="btn-secondary">← Data Peminjaman</a>
        </div>

        <!-- FILTER ANGGOTA -->
        <form method="GET" class="search-form">
            <select name="id_anggota">
                <option value="">-- Semua Anggota --</option>
                <?php foreach ($daftarAnggota as $a): ?>
                    <option
                        value="<?= (int) $a['id_anggota'] ?>"
                        <?= $idAnggota === (int) $a['id_anggota'] ? 'selected' : '' ?>
                    >
                        <?= e($a['nim']) ?> - <?= e($a['nama']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn-primary">Tampilkan</button>
        </form>

        <?php if ($ringkasan): ?>
            <section class="summary-grid">
                <div class="summary-card">
                    <span>Total Peminjaman</span>
                    <strong><?= e($ringkasan['total']) ?></strong>
                </div>
                <div class="summary-card">
                    <span>Sedang Dipinjam</span>
                    <strong><?= e($ringkasan['aktif']) ?></strong>
                </div>
                <div class="summary-card">
                    <span>Terlambat</span>
                    <strong><?= e($ringkasan['terlambat']) ?></strong>
                </div>
            </section>
        <?php endif; ?>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <?php if (!$anggota): ?><th>Anggota</th><?php endif; ?>
                        <th>Barang</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                <?php if (count($riwayat) > 0): ?>
                    <?php foreach ($riwayat as $index => $item): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>

                            <?php if (!$anggota): ?>
                                <td>
                                    <a href="?id_anggota=<?= (int) $item['id_anggota'] ?>">
                                        <strong><?= e($item['nama_anggota']) ?></strong>
                                    </a>
                                    <br><small><?= e($item['nim']) ?></small>
                                </td>
                            <?php endif; ?>

                            <td>
                                <strong><?= e($item['nama_barang']) ?></strong>
                                <br><small><?= e($item['kode_barang']) ?></small>
                            </td>
                            <td><?= e($item['tanggal_pinjam']) ?></td>
                            <td><?= $item['tanggal_kembali'] ? e($item['tanggal_kembali']) : '-' ?></td>
                            <td>
                                <span class="<?= e(status_class($item['status'])) ?>">
                                    <?= e(status_label($item['status'])) ?>
                                </span>
                                <?php if (db_bool($item['terlambat'])): ?>
                                    <br><small style="color:#b91c1c;">
                                        Terlambat <?= e((int) $item['lama_hari'] - (int) BATAS_HARI_PINJAM) ?> hari
                                    </small>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?= $anggota ? 5 : 6 ?>" style="text-align: center;">
                            Belum ada riwayat peminjaman.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination-info">
            Menampilkan <?= count($riwayat) ?> riwayat terbaru (maksimal 100).
        </div>

    </main>

</div>

<script src="<?= BASE_URL ?>/assets/js/app.js"></script>

</body>
</html>
