<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

$keyword = trim($_GET['keyword'] ?? '');

$page = isset($_GET['page'])
    ? max(1, (int) $_GET['page'])
    : 1;

$limit = 10;

$offset = ($page - 1) * $limit;


/* ============================
   TOTAL DATA
============================ */

$countStmt = $pdo->prepare("
    SELECT COUNT(*)
    FROM barang
    WHERE nama_barang ILIKE :keyword
");

$countStmt->execute([
    ':keyword' => '%' . $keyword . '%'
]);

$totalData = (int) $countStmt->fetchColumn();

$totalPage = max(
    1,
    (int) ceil($totalData / $limit)
);

if ($page > $totalPage) {
    $page = $totalPage;
    $offset = ($page - 1) * $limit;
}


/* ============================
   DATA BARANG
============================ */

$stmt = $pdo->prepare("
    SELECT
        b.id_barang,
        b.kode_barang,
        b.nama_barang,
        b.jumlah,
        k.nama_kategori
    FROM barang b
    JOIN kategori k
        ON b.id_kategori = k.id_kategori
    WHERE b.nama_barang ILIKE :keyword
    ORDER BY b.id_barang ASC
    LIMIT :limit
    OFFSET :offset
");

$stmt->bindValue(
    ':keyword',
    '%' . $keyword . '%',
    PDO::PARAM_STR
);

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

$barang = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Data Barang - Inventaris HIMA</title>

    <link
        rel="stylesheet"
        href="/assets/css/style.css"
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

            <a href="/auth/logout.php">
                Logout
            </a>

        </div>


        <nav>

            <a href="/">
                Dashboard
            </a>

            <a
                href="/barang/list.php"
                class="active"
            >
                Data Barang
            </a>

            <a href="/peminjaman/list.php">
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
                    Data Barang
                </h1>

                <p>
                    Kelola data barang inventaris HIMA.
                </p>

            </div>


            <a
                href="/barang/tambah.php"
                class="btn-primary"
            >
                + Tambah Barang
            </a>

        </div>


        <!-- SEARCH -->

        <form
            method="GET"
            class="search-form"
        >

            <input
                type="text"
                name="keyword"
                placeholder="Cari nama barang..."
                value="<?= htmlspecialchars($keyword) ?>"
            >

            <button
                type="submit"
                class="btn-primary"
            >
                Cari
            </button>

        </form>


        <!-- TABLE -->

        <div class="table-card">

            <table>

                <thead>

                    <tr>

                        <th>
                            No
                        </th>

                        <th>
                            Kode Barang
                        </th>

                        <th>
                            Nama Barang
                        </th>

                        <th>
                            Kategori
                        </th>

                        <th>
                            Jumlah
                        </th>

                        <th>
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                <?php if (count($barang) > 0): ?>

                    <?php foreach ($barang as $index => $item): ?>

                        <tr>

                            <td>
                                <?= $offset + $index + 1 ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($item['kode_barang']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($item['nama_barang']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($item['nama_kategori']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($item['jumlah']) ?>
                            </td>

                            <td>

                                <div class="action-group">

                                    <a
                                        href="/barang/edit.php?id=<?= $item['id_barang'] ?>"
                                        class="btn-secondary"
                                    >
                                        Edit
                                    </a>


                                    <?php if ($_SESSION['role'] === 'admin'): ?>

                                        <form
                                            action="/barang/hapus.php"
                                            method="POST"
                                        >

                                            <input
                                                type="hidden"
                                                name="id_barang"
                                                value="<?= $item['id_barang'] ?>"
                                            >

                                            <button
                                                type="submit"
                                                class="danger"
                                                onclick="return confirm('Yakin ingin menghapus barang ini?')"
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
                            colspan="6"
                            style="text-align: center;"
                        >
                            Data barang tidak ditemukan.
                        </td>

                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>


        <!-- PAGINATION -->

        <div class="pagination-info">

            Menampilkan
            <?= count($barang) ?>
            dari
            <?= $totalData ?>
            data barang

        </div>


        <?php if ($totalPage > 1): ?>

            <div class="pagination">

                <?php if ($page > 1): ?>

                    <a
                        href="?keyword=<?= urlencode($keyword) ?>&page=<?= $page - 1 ?>"
                    >
                        ← Sebelumnya
                    </a>

                <?php endif; ?>


                <span>
                    Halaman <?= $page ?> dari <?= $totalPage ?>
                </span>


                <?php if ($page < $totalPage): ?>

                    <a
                        href="?keyword=<?= urlencode($keyword) ?>&page=<?= $page + 1 ?>"
                    >
                        Berikutnya →
                    </a>

                <?php endif; ?>

            </div>

        <?php endif; ?>

    </main>

</div>


<script src="/assets/js/app.js"></script>

</body>

</html>