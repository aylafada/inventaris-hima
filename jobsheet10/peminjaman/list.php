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
        href="../assets/css/style.css"
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
                <?= htmlspecialchars($_SESSION['nama']) ?>
            </strong>

            <span>
                <?= htmlspecialchars($_SESSION['role']) ?>
            </span>

            <a href="../auth/logout.php">
                Logout
            </a>

        </div>


        <nav>

            <a href="../index.php">
                Dashboard
            </a>

            <a href="../barang/list.php">
                Data Barang
            </a>

            <a
                href="list.php"
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
                href="tambah.php"
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
                                    <?= htmlspecialchars($item['nama_barang']) ?>
                                </strong>
                                <br>
                                <small>
                                    <?= htmlspecialchars($item['kode_barang']) ?>
                                </small>
                            </td>
                            <td>
                                <?= htmlspecialchars($item['nama_peminjam']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($item['tanggal_pinjam']) ?>
                            </td>

                            <td>
                                <?= $item['tanggal_kembali']
                                    ? htmlspecialchars($item['tanggal_kembali'])
                                    : '-'
                                ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($item['status']) ?>
                            </td>
                            <td>
                                <div class="action-group">

                                    <?php if ($item['status'] === 'Dipinjam'): ?>
                                        <a
                                            href="edit.php?id=<?= $item['id_peminjaman'] ?>"
                                            class="btn-secondary"
                                        >
                                            Edit
                                        </a>

                                        <a
                                            href="kembali.php?id=<?= $item['id_peminjaman'] ?>"
                                            class="btn-secondary"
                                            onclick="return confirm('Yakin ingin mengembalikan barang ini?')"
                                        >
                                            Kembalikan
                                        </a>
                                    <?php else: ?>
                                        <a
                                            href="edit.php?id=<?= $item['id_peminjaman'] ?>"
                                            class="btn-secondary"
                                        >
                                            Edit
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($_SESSION['role'] === 'admin'): ?>
                                        <form
                                            action="hapus.php"
                                            method="POST"
                                        >
                                            <input
                                                type="hidden"
                                                name="id_peminjaman"
                                                value="<?= $item['id_peminjaman'] ?>"
                                            >
                                            <button
                                                type="submit"
                                                class="danger"
                                                onclick="return confirm('Yakin ingin menghapus data peminjaman ini?')"
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
            <?= $totalData ?>
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


<script src="../assets/js/app.js"></script>
</body>
</html>