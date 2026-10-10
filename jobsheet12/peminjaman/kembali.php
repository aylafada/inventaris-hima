<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

/*
| Pengembalian: daftar transaksi AKTIF (status = 'Dipinjam').
| Tombol "Kembalikan" mengirim POST + token CSRF ke proses_kembali.php.
*/
$stmt = $pdo->query('
    SELECT
        p.id_peminjaman,
        COALESCE(a.nama, p.nama_peminjam) AS nama_peminjam,
        a.nim,
        p.tanggal_pinjam,
        (CURRENT_DATE - p.tanggal_pinjam) AS lama_hari,
        ' . sql_terlambat('p') . ' AS terlambat,
        b.kode_barang,
        b.nama_barang
    FROM peminjaman p
    JOIN barang b
        ON p.id_barang = b.id_barang
    LEFT JOIN anggota a
        ON p.id_anggota = a.id_anggota
    WHERE p.status = \'Dipinjam\'
    ORDER BY p.tanggal_pinjam ASC, p.id_peminjaman ASC
    LIMIT 200
');
$aktif = $stmt->fetchAll(PDO::FETCH_ASSOC);

$menuAktif = 'kembali';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengembalian - Inventaris HIMA</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>

<div class="layout">

    <?php require __DIR__ . '/../includes/sidebar.php'; ?>

    <main class="content">

        <div class="page-header">
            <div>
                <p class="eyebrow">PEMINJAMAN</p>
                <h1>Pengembalian Barang</h1>
                <p>Daftar transaksi yang masih aktif. Klik Kembalikan saat barang sudah diterima.</p>
            </div>

            <a href="<?= BASE_URL ?>/peminjaman/tambah.php" class="btn-primary">
                + Peminjaman Baru
            </a>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
                        <th>Peminjam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Lama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php if (count($aktif) > 0): ?>
                    <?php foreach ($aktif as $index => $item): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td>
                                <strong><?= e($item['nama_barang']) ?></strong>
                                <br><small><?= e($item['kode_barang']) ?></small>
                            </td>
                            <td>
                                <?= e($item['nama_peminjam']) ?>
                                <?php if ($item['nim'] !== null): ?>
                                    <br><small><?= e($item['nim']) ?></small>
                                <?php endif; ?>
                            </td>
                            <td><?= e($item['tanggal_pinjam']) ?></td>
                            <td>
                                <?= e((int) $item['lama_hari']) ?> hari
                                <?php if (db_bool($item['terlambat'])): ?>
                                    <br><small style="color:#b91c1c;">
                                        Terlambat <?= e((int) $item['lama_hari'] - (int) BATAS_HARI_PINJAM) ?> hari
                                    </small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <form action="<?= BASE_URL ?>/peminjaman/proses_kembali.php" method="POST">
<?= csrf_field() ?>
                                    <input type="hidden" name="id_peminjaman" value="<?= (int) $item['id_peminjaman'] ?>">
                                    <input type="hidden" name="dari" value="kembali">
                                    <button
                                        type="submit"
                                        class="btn-primary"
                                        data-confirm="Yakin barang ini sudah dikembalikan?"
                                    >
                                        Kembalikan
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">
                            Tidak ada peminjaman yang sedang berjalan.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination-info">
            <?= count($aktif) ?> transaksi aktif
        </div>

    </main>

</div>

<script src="<?= BASE_URL ?>/assets/js/app.js"></script>

</body>
</html>
