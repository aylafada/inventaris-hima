<?php

require_once __DIR__ . '/../includes/koneksi.php';

/*
|--------------------------------------------------------------------------
| SEARCH
|--------------------------------------------------------------------------
*/

$keyword = trim($_GET['keyword'] ?? '');

/*
|--------------------------------------------------------------------------
| PAGINATION
|--------------------------------------------------------------------------
*/

$limit = 10;

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($page < 1) {
    $page = 1;
}

$searchCondition = '';
$params = [];

if ($keyword !== '') {
    $searchCondition = "WHERE b.nama_barang ILIKE :keyword";
    $params[':keyword'] = '%' . $keyword . '%';
}

/*
|--------------------------------------------------------------------------
| HITUNG TOTAL DATA
|--------------------------------------------------------------------------
*/

$countSql = "
    SELECT COUNT(*)
    FROM barang b
    $searchCondition
";

$countStmt = $pdo->prepare($countSql);
$countStmt->execute($params);

$totalData = (int) $countStmt->fetchColumn();

$totalPages = max(1, (int) ceil($totalData / $limit));

if ($page > $totalPages) {
    $page = $totalPages;
}

$offset = ($page - 1) * $limit;

/*
|--------------------------------------------------------------------------
| AMBIL DATA BARANG
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT
        b.id_barang,
        b.kode_barang,
        b.nama_barang,
        k.nama_kategori,
        b.jumlah
    FROM barang b
    JOIN kategori k
        ON b.id_kategori = k.id_kategori
    $searchCondition
    ORDER BY b.id_barang DESC
    LIMIT $limit OFFSET $offset
";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

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

    <aside class="sidebar">

        <h2>Inventaris HIMA</h2>

        <p class="sidebar-subtitle">
            Sistem Inventaris
        </p>

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


    <main class="content">

        <div class="page-header">

            <div>

                <p class="eyebrow">
                    Inventaris
                </p>

                <h1>
                    Data Barang
                </h1>

                <p>
                    Daftar barang yang dimiliki oleh HIMA.
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
            action="/barang/list.php"
            class="search-form"
        >

            <input
                type="text"
                name="keyword"
                value="<?= htmlspecialchars($keyword) ?>"
                placeholder="Cari nama barang..."
            >

            <button
                type="submit"
                class="btn-primary"
            >
                Cari
            </button>

            <?php if ($keyword !== ''): ?>

                <a
                    href="/barang/list.php"
                    class="btn-secondary"
                >
                    Reset
                </a>

            <?php endif; ?>

        </form>


        <?php if (count($barang) > 0): ?>

            <div class="barang-grid">

                <?php foreach ($barang as $item): ?>

                    <div class="barang-card">

                        <div class="barang-info">

                            <span class="barang-code">
                                <?= htmlspecialchars($item['kode_barang']) ?>
                            </span>

                            <h3>
                                <?= htmlspecialchars($item['nama_barang']) ?>
                            </h3>

                            <p>
                                <?= htmlspecialchars($item['nama_kategori']) ?>
                            </p>

                            <div class="barang-stock">

                                <span>
                                    Jumlah
                                </span>

                                <strong>
                                    <?= $item['jumlah'] ?>
                                </strong>

                            </div>

                        </div>


                        <div class="card-actions">

                            <a
                                href="/barang/edit.php?id=<?= $item['id_barang'] ?>"
                                class="btn-small"
                            >
                                Edit
                            </a>


                            <form
                                action="/barang/hapus.php"
                                method="POST"
                                style="display: inline;"
                                onsubmit="return confirm('Yakin ingin menghapus barang ini?')"
                            >

                                <input
                                    type="hidden"
                                    name="id_barang"
                                    value="<?= $item['id_barang'] ?>"
                                >

                                <button
                                    type="submit"
                                    class="btn-small danger"
                                >
                                    Hapus
                                </button>

                            </form>

                        </div>

                    </div>

                <?php endforeach; ?>

            </div>


            <!-- PAGINATION -->

            <?php if ($totalPages > 1): ?>

                <div class="pagination">

                    <?php if ($page > 1): ?>

                        <a
                            href="/barang/list.php?keyword=<?= urlencode($keyword) ?>&page=<?= $page - 1 ?>"
                            class="btn-small"
                        >
                            ← Sebelumnya
                        </a>

                    <?php endif; ?>


                    <span class="pagination-info">
                        Halaman <?= $page ?> dari <?= $totalPages ?>
                    </span>


                    <?php if ($page < $totalPages): ?>

                        <a
                            href="/barang/list.php?keyword=<?= urlencode($keyword) ?>&page=<?= $page + 1 ?>"
                            class="btn-small"
                        >
                            Berikutnya →
                        </a>

                    <?php endif; ?>

                </div>

            <?php endif; ?>


        <?php else: ?>

            <div class="empty-state">

                <h3>
                    <?= $keyword !== ''
                        ? 'Barang tidak ditemukan'
                        : 'Belum ada barang'
                    ?>
                </h3>

                <p>

                    <?php if ($keyword !== ''): ?>

                        Tidak ada barang yang sesuai dengan pencarian
                        "<?= htmlspecialchars($keyword) ?>".

                    <?php else: ?>

                        Tambahkan barang pertama ke inventaris HIMA.

                    <?php endif; ?>

                </p>


                <?php if ($keyword === ''): ?>

                    <a
                        href="/barang/tambah.php"
                        class="btn-primary"
                    >
                        + Tambah Barang
                    </a>

                <?php else: ?>

                    <a
                        href="/barang/list.php"
                        class="btn-secondary"
                    >
                        Tampilkan Semua Barang
                    </a>

                <?php endif; ?>

            </div>

        <?php endif; ?>

    </main>

</div>


<script src="/assets/js/app.js"></script>

</body>
</html>