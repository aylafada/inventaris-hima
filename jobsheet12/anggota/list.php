<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

$keyword = $_GET['keyword'] ?? '';
$keyword = is_string($keyword) ? text_cut(trim($keyword), 100) : '';

// Escape karakter wildcard LIKE (% dan _) agar dicari apa adanya
$keywordLike = '%' . addcslashes($keyword, '\\%_') . '%';

$page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

/* TOTAL DATA */
$countStmt = $pdo->prepare('
    SELECT COUNT(*)
    FROM anggota
    WHERE nama ILIKE :kw1 OR nim ILIKE :kw2
');
$countStmt->execute([':kw1' => $keywordLike, ':kw2' => $keywordLike]);
$totalData = (int) $countStmt->fetchColumn();

$totalPage = max(1, (int) ceil($totalData / $limit));

if ($page > $totalPage) {
    $page = $totalPage;
    $offset = ($page - 1) * $limit;
}

/* DATA ANGGOTA + jumlah pinjaman aktif & terlambat */
$stmt = $pdo->prepare('
    SELECT
        a.id_anggota,
        a.nim,
        a.nama,
        a.no_hp,
        COUNT(p.id_peminjaman) FILTER (WHERE p.status = \'Dipinjam\') AS aktif,
        COUNT(p.id_peminjaman) FILTER (WHERE ' . sql_terlambat('p') . ') AS terlambat
    FROM anggota a
    LEFT JOIN peminjaman p
        ON p.id_anggota = a.id_anggota
    WHERE a.nama ILIKE :kw1 OR a.nim ILIKE :kw2
    GROUP BY a.id_anggota, a.nim, a.nama, a.no_hp
    ORDER BY a.nama ASC
    LIMIT :limit OFFSET :offset
');
$stmt->bindValue(':kw1', $keywordLike, PDO::PARAM_STR);
$stmt->bindValue(':kw2', $keywordLike, PDO::PARAM_STR);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$anggota = $stmt->fetchAll(PDO::FETCH_ASSOC);

$menuAktif = 'anggota';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anggota - Inventaris HIMA</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>

<div class="layout">

    <?php require __DIR__ . '/../includes/sidebar.php'; ?>

    <main class="content">

        <div class="page-header">
            <div>
                <p class="eyebrow">INVENTARIS</p>
                <h1>Data Anggota</h1>
                <p>Kelola data anggota HIMA yang boleh meminjam barang.</p>
            </div>

            <a href="<?= BASE_URL ?>/anggota/tambah.php" class="btn-primary">
                + Tambah Anggota
            </a>
        </div>

        <form method="GET" class="search-form">
            <input
                type="text"
                name="keyword"
                placeholder="Cari nama atau NIM..."
                value="<?= e($keyword) ?>"
            >
            <button type="submit" class="btn-primary">Cari</button>
        </form>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>No. HP</th>
                        <th>Sedang Dipinjam</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                <?php if (count($anggota) > 0): ?>
                    <?php foreach ($anggota as $index => $item): ?>
                        <tr>
                            <td><?= $offset + $index + 1 ?></td>
                            <td><?= e($item['nim']) ?></td>
                            <td><strong><?= e($item['nama']) ?></strong></td>
                            <td><?= $item['no_hp'] !== null && $item['no_hp'] !== '' ? e($item['no_hp']) : '-' ?></td>
                            <td>
                                <?= e($item['aktif']) ?>
                                <?php if ((int) $item['terlambat'] > 0): ?>
                                    <br><small style="color:#b91c1c;">
                                        <?= e($item['terlambat']) ?> terlambat
                                    </small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="action-group">
                                    <a
                                        href="<?= BASE_URL ?>/peminjaman/riwayat.php?id_anggota=<?= (int) $item['id_anggota'] ?>"
                                        class="btn-secondary"
                                    >
                                        Riwayat
                                    </a>

                                    <a
                                        href="<?= BASE_URL ?>/anggota/edit.php?id=<?= (int) $item['id_anggota'] ?>"
                                        class="btn-secondary"
                                    >
                                        Edit
                                    </a>

                                    <?php if ($_SESSION['role'] === 'admin'): ?>
                                        <form action="<?= BASE_URL ?>/anggota/hapus.php" method="POST">
<?= csrf_field() ?>
                                            <input type="hidden" name="id_anggota" value="<?= (int) $item['id_anggota'] ?>">
                                            <button
                                                type="submit"
                                                class="danger"
                                                data-confirm="Yakin ingin menghapus anggota ini?"
                                            >
                                                Hapus
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">
                            Data anggota tidak ditemukan.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="pagination-info">
            Menampilkan <?= count($anggota) ?> dari <?= e($totalData) ?> data anggota
        </div>

        <?php if ($totalPage > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?keyword=<?= urlencode($keyword) ?>&page=<?= $page - 1 ?>">← Sebelumnya</a>
                <?php endif; ?>

                <span>Halaman <?= $page ?> dari <?= $totalPage ?></span>

                <?php if ($page < $totalPage): ?>
                    <a href="?keyword=<?= urlencode($keyword) ?>&page=<?= $page + 1 ?>">Berikutnya →</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

    </main>

</div>

<script src="<?= BASE_URL ?>/assets/js/app.js"></script>

</body>
</html>
