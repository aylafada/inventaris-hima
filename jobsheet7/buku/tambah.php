<?php
require_once __DIR__ . '/../includes/init.php';

$errors = $_SESSION['form_error'] ?? [];
$old = $_SESSION['old_buku'] ?? [];

unset($_SESSION['form_error']);
unset($_SESSION['old_buku']);
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<main>
    <section>
        <h2>Tambah Buku Baru</h2>
        <?php if (!empty($errors)): ?>
            <div class="flash error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form id="form-tambah" method="post" action="proses_tambah.php">
            <div class="form-group">
                <label for="judul">Judul Buku</label>
                <input
                    type="text"
                    id="judul"
                    name="judul"
                    value="<?= htmlspecialchars($old['judul'] ?? '') ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="pengarang">Pengarang</label>
                <input
                    type="text"
                    id="pengarang"
                    name="pengarang"
                    value="<?= htmlspecialchars($old['pengarang'] ?? '') ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="tahun">Tahun Terbit</label>
                <input
                    type="number"
                    id="tahun"
                    name="tahun"
                    value="<?= htmlspecialchars($old['tahun'] ?? '') ?>"
                    required
                >
            </div>

            <div class="form-group">
                <label for="stok">Jumlah Stok</label>
                <input
                    type="number"
                    id="stok"
                    name="stok"
                    value="<?= htmlspecialchars($old['stok'] ?? '') ?>"
                    required
                >
            </div>

            <div class="form-actions">
                <button type="submit">Simpan</button>
            </div>

        </form>
    </section>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>