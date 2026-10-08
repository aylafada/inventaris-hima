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
        p.nama_peminjam,
        p.tanggal_pinjam,
        p.tanggal_kembali,
        p.status,
        b.kode_barang,
        b.nama_barang
    FROM peminjaman p
    JOIN barang b
        ON p.id_barang = b.id_barang
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

    <aside class="sidebar">

        <h2>
            Inventaris HIMA
        </h2>

        <p class="sidebar-subtitle">
            Sistem Inventaris
        </p>


        <!-- USER -->

        <div class="user-info">

            <strong>
                <?= e($_SESSION['nama']) ?>
            </strong>

            <span>
                <?= e($_SESSION['role']) ?>
            </span>

            <a href="<?= BASE_URL ?>/auth/logout.php">
                Logout
            </a>

        </div>


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


            <a
                href="<?= BASE_URL ?>/peminjaman/tambah.php"
                class="btn-primary"
            >
                + Tambah Peminjaman
            </a>
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
                                <?= e($item['nama_peminjam']) ?>
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
                                <?= e($item['status']) ?>
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
                                            action="<?= BASE_URL ?>/peminjaman/kembalikan.php"
                                            method="POST"
                                        >
<?= csrf_field() ?>
                                            <input
                                                type="hidden"
                                                name="id_peminjaman"
                                                value="<?= (int) $item['id_peminjaman'] ?>"
                                            >
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