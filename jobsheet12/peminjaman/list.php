<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

$page = isset($_GET['page'])
    ? max(1, (int) $_GET['page'])
    : 1;

$limit = 10;

$offset = ($page - 1) * $limit;


/* ============================
   TOTAL DATA
============================ */

$totalData = (int) $pdo->query("
    SELECT COUNT(*)
    FROM peminjaman
")->fetchColumn();

$totalPage = max(
    1,
    (int) ceil($totalData / $limit)
);

if ($page > $totalPage) {
    $page = $totalPage;
    $offset = ($page - 1) * $limit;
}


/* ============================
   DATA PEMINJAMAN
============================ */

$stmt = $pdo->prepare("
    SELECT
        p.id_peminjaman,
        p.id_anggota,
        COALESCE(a.nama, p.nama_peminjam) AS nama_peminjam,
        a.nim,
        p.tanggal_pinjam,
        p.tanggal_kembali,
        p.status,
        (CURRENT_DATE - p.tanggal_pinjam) AS lama_hari,
        " . sql_terlambat('p') . " AS terlambat,
        b.kode_barang,
        b.nama_barang
    FROM peminjaman p
    JOIN barang b
        ON p.id_barang = b.id_barang
    LEFT JOIN anggota a
        ON p.id_anggota = a.id_anggota
    ORDER BY p.id_peminjaman DESC
    LIMIT :limit
    OFFSET :offset
");

$stmt->bindValue(
    ':limit',
    $limit,
    PDO::PARAM_INT
);

$stmt->bindValue(
    ':offset',
    $offset,
    PDO::PARAM_INT
);

$stmt->execute();

$peminjaman = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Peminjaman - Inventaris HIMA</title>

    <link
        rel="stylesheet"
        href="<?= BASE_URL ?>/assets/css/style.css"
    >

</head>

<body>

<div class="layout">

    <!-- SIDEBAR -->

    <?php $menuAktif = 'peminjaman'; require __DIR__ . '/../includes/sidebar.php'; ?>


    <!-- CONTENT -->

    <main class="content">

        <div class="page-header">

            <div>

                <p class="eyebrow">
                    INVENTARIS
                </p>

                <h1>
                    Data Peminjaman
                </h1>

                <p>
                    Kelola data peminjaman inventaris HIMA.
                </p>

            </div>


            <div class="action-group">
                <a href="<?= BASE_URL ?>/peminjaman/riwayat.php" class="btn-secondary">Riwayat</a>
                <a
                href="<?= BASE_URL ?>/peminjaman/tambah.php"
                class="btn-primary"
            >
                + Tambah Peminjaman
            </a>
            </div>
        </div>


        <!-- TABLE -->
        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>
                            No
                        </th>
                        <th>
                            Barang
                        </th>
                        <th>
                            Peminjam
                        </th>
                        <th>
                            Tanggal Pinjam
                        </th>
                        <th>
                            Tanggal Kembali
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Aksi
                        </th>
                    </tr>
                </thead>

                <tbody>
                <?php if (count($peminjaman) > 0): ?>
                    <?php foreach ($peminjaman as $index => $item): ?>
                        <tr>
                            <td>
                                <?= $offset + $index + 1 ?>
                            </td>
                            <td>
                                <strong>
                                    <?= e($item['nama_barang']) ?>
                                </strong>
                                <br>
                                <small>
                                    <?= e($item['kode_barang']) ?>
                                </small>
                            </td>
                            <td>
                                <?php if ($item['id_anggota'] !== null): ?>
                                    <a href="<?= BASE_URL ?>/peminjaman/riwayat.php?id_anggota=<?= (int) $item['id_anggota'] ?>">
                                        <strong><?= e($item['nama_peminjam']) ?></strong>
                                    </a>
                                    <br><small><?= e($item['nim']) ?></small>
                                <?php else: ?>
                                    <?= e($item['nama_peminjam']) ?>
                                    <br><small>(data lama, belum terhubung ke anggota)</small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= e($item['tanggal_pinjam']) ?>
                            </td>

                            <td>
                                <?= $item['tanggal_kembali']
                                    ? e($item['tanggal_kembali'])
                                    : '-'
                                ?>
                            </td>
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
                            <td>
                                <div class="action-group">

                                    <?php if ($item['status'] === 'Dipinjam'): ?>
                                        <a
                                            href="<?= BASE_URL ?>/peminjaman/edit.php?id=<?= e($item['id_peminjaman']) ?>"
                                            class="btn-secondary"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="<?= BASE_URL ?>/peminjaman/proses_kembali.php"
                                            method="POST"
                                        >
<?= csrf_field() ?>
                                            <input
                                                type="hidden"
                                                name="id_peminjaman"
                                                value="<?= (int) $item['id_peminjaman'] ?>"
                                            >
                                            <input type="hidden" name="dari" value="list">
                                            <button
                                                type="submit"
                                                class="btn-secondary"
                                                data-confirm="Yakin ingin mengembalikan barang ini?"
                                            >
                                                Kembalikan
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <a
                                            href="<?= BASE_URL ?>/peminjaman/edit.php?id=<?= e($item['id_peminjaman']) ?>"
                                            class="btn-secondary"
                                        >
                                            Edit
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($_SESSION['role'] === 'admin'): ?>
                                        <form
                                            action="<?= BASE_URL ?>/peminjaman/hapus.php"
                                            method="POST"
                                        >
<?= csrf_field() ?>
                                            <input
                                                type="hidden"
                                                name="id_peminjaman"
                                                value="<?= e($item['id_peminjaman']) ?>"
                                            >
                                            <button
                                                type="submit"
                                                class="danger"
                                                data-confirm="Yakin ingin menghapus data peminjaman ini?"
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
                        <td
                            colspan="7"
                            style="text-align: center;"
                        >
                            Belum ada data peminjaman.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>


        <!-- PAGINATION -->

        <div class="pagination-info">
            Menampilkan
            <?= count($peminjaman) ?>
            dari
            <?= e($totalData) ?>
            data peminjaman
        </div>


        <?php if ($totalPage > 1): ?>
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a
                        href="?page=<?= $page - 1 ?>"
                    >
                        ← Sebelumnya
                    </a>
                <?php endif; ?>

                <span>
                    Halaman <?= $page ?> dari <?= $totalPage ?>
                </span>

                <?php if ($page < $totalPage): ?>
                    <a
                        href="?page=<?= $page + 1 ?>"
                    >
                        Berikutnya →
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </main>
</div>


<script src="<?= BASE_URL ?>/assets/js/app.js"></script>
</body>
</html>