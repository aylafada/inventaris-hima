<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/koneksi.php';

$keyword = $_GET['keyword'] ?? '';
$keyword = is_string($keyword) ? text_cut(trim($keyword), 100) : '';

// Escape karakter wildcard LIKE (% dan _) agar dicari apa adanya
$keywordLike = addcslashes($keyword, '\\%_');

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
    ':keyword' => '%' . $keywordLike . '%'
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
    '%' . $keywordLike . '%',
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

            <a
                href="<?= BASE_URL ?>/barang/list.php"
                class="active"
            >
                Data Barang
            </a>

            <a href="<?= BASE_URL ?>/peminjaman/list.php">
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
                href="<?= BASE_URL ?>/barang/tambah.php"
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
                value="<?= e($keyword) ?>"
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
                                <?= e($item['kode_barang']) ?>
                            </td>

                            <td>
                                <?= e($item['nama_barang']) ?>
                            </td>

                            <td>
                                <?= e($item['nama_kategori']) ?>
                            </td>

                            <td>
                                <?= e($item['jumlah']) ?>
                            </td>

                            <td>

                                <div class="action-group">

                                    <a
                                        href="<?= BASE_URL ?>/barang/edit.php?id=<?= e($item['id_barang']) ?>"
                                        class="btn-secondary"
                                    >
                                        Edit
                                    </a>


                                    <?php if ($_SESSION['role'] === 'admin'): ?>

                                        <form
                                            action="<?= BASE_URL ?>/barang/hapus.php"
                                            method="POST"
                                        >
<?= csrf_field() ?>

                                            <input
                                                type="hidden"
                                                name="id_barang"
                                                value="<?= e($item['id_barang']) ?>"
                                            >

                                            <button
                                                type="submit"
                                                class="danger"
                                                data-confirm="Yakin ingin menghapus barang ini?"
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
            <?= e($totalData) ?>
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


<script src="<?= BASE_URL ?>/assets/js/app.js"></script>

</body>

</html>