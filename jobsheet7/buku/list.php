<?php
require_once __DIR__ . '/../includes/init.php';
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<main>

    <section>
        <h2>Daftar Buku</h2>
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="flash <?= $_SESSION['flash']['type'] ?>">
                <?= htmlspecialchars($_SESSION['flash']['pesan']) ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <div class="search-box">
            <label for="search-buku">Cari Buku</label>
            <input
                type="text"
                id="search-buku"
                placeholder="Cari berdasarkan judul..."
            >
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Stok</th>
                        <th>Tahun</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tabel-buku">
                    <?php foreach ($_SESSION['buku'] as $buku): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($buku['judul']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($buku['pengarang']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($buku['stok']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($buku['tahun']) ?>
                            </td>
                            <td>
                                <button type="button">
                                    Edit
                                </button>
                                <button type="button">
                                    Detail
                                </button>
                                <button type="button" class="btn-hapus">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>