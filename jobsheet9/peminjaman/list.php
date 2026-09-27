<?php

require_once __DIR__ . '/../includes/koneksi.php';

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


/*
|--------------------------------------------------------------------------
| HITUNG TOTAL DATA
|--------------------------------------------------------------------------
*/

$countStmt = $pdo->query("
    SELECT COUNT(*)
    FROM peminjaman
");

$totalData = (int) $countStmt->fetchColumn();

$totalPages = max(
    1,
    (int) ceil($totalData / $limit)
);

if ($page > $totalPages) {
    $page = $totalPages;
}

$offset = ($page - 1) * $limit;


/*
|--------------------------------------------------------------------------
| AMBIL DATA
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT
        p.id_peminjaman,
        b.kode_barang,
        b.nama_barang,
        p.nama_peminjam,
        p.tanggal_pinjam,
        p.tanggal_kembali,
        p.status
    FROM peminjaman p
    JOIN barang b
        ON p.id_barang = b.id_barang
    ORDER BY p.id_peminjaman DESC
    LIMIT $limit OFFSET $offset
";

$stmt = $pdo->query($sql);

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

            <a href="/barang/list.php">
                Data Barang
            </a>

            <a
                href="/peminjaman/list.php"
                class="active"
            >
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
                    Peminjaman
                </h1>

                <p>
                    Daftar peminjaman barang HIMA.
                </p>

            </div>

            <a
                href="/peminjaman/tambah.php"
                class="btn-primary"
            >
                + Tambah Peminjaman
            </a>

        </div>


        <div class="table-card">

            <?php if (count($peminjaman) > 0): ?>

                <table>

                    <thead>

                        <tr>

                            <th>No</th>
                            <th>Barang</th>
                            <th>Peminjam</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Aksi</th>

                        </tr>

                    </thead>


                    <tbody>

                        <?php $no = $offset + 1; ?>

                        <?php foreach ($peminjaman as $item): ?>

                            <tr>

                                <td>
                                    <?= $no++ ?>
                                </td>


                                <td>

                                    <strong>
                                        <?= htmlspecialchars($item['kode_barang']) ?>
                                    </strong>

                                    <br>

                                    <?= htmlspecialchars($item['nama_barang']) ?>

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

                                    <?php if ($item['status'] === 'Dipinjam'): ?>

                                        <span class="status-badge">
                                            Dipinjam
                                        </span>

                                    <?php else: ?>

                                        <span class="status-badge selesai">
                                            Selesai
                                        </span>

                                    <?php endif; ?>

                                </td>


                                <td>

                                    <div class="card-actions">

                                        <a
                                            href="/peminjaman/edit.php?id=<?= $item['id_peminjaman'] ?>"
                                            class="btn-small"
                                        >
                                            Edit
                                        </a>


                                        <?php if ($item['status'] === 'Dipinjam'): ?>

                                            <a
                                                href="/peminjaman/kembalikan.php?id=<?= $item['id_peminjaman'] ?>"
                                                class="btn-small"
                                                onclick="return confirm('Kembalikan barang ini?')"
                                            >
                                                Kembalikan
                                            </a>

                                        <?php endif; ?>


                                        <form
                                            action="/peminjaman/hapus.php"
                                            method="POST"
                                            style="display: inline;"
                                            onsubmit="return confirm('Yakin ingin menghapus data peminjaman ini?')"
                                        >

                                            <input
                                                type="hidden"
                                                name="id_peminjaman"
                                                value="<?= $item['id_peminjaman'] ?>"
                                            >

                                            <button
                                                type="submit"
                                                class="btn-small danger"
                                            >
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>


                <?php if ($totalPages > 1): ?>

                    <div class="pagination">

                        <?php if ($page > 1): ?>

                            <a
                                href="/peminjaman/list.php?page=<?= $page - 1 ?>"
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
                                href="/peminjaman/list.php?page=<?= $page + 1 ?>"
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
                        Belum ada peminjaman
                    </h3>

                    <p>
                        Belum terdapat data peminjaman barang.
                    </p>

                    <a
                        href="/peminjaman/tambah.php"
                        class="btn-primary"
                    >
                        + Tambah Peminjaman
                    </a>

                </div>

            <?php endif; ?>

        </div>

    </main>

</div>


<script src="/assets/js/app.js"></script>

</body>
</html>