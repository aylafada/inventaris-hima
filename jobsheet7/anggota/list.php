<?php
require_once __DIR__ . '/../includes/init.php';
?>

<?php include __DIR__ . '/../includes/header.php'; ?>

<main>

    <section>

        <h2>Daftar Anggota</h2>

        <?php if (isset($_SESSION['flash'])): ?>

            <div class="flash <?= $_SESSION['flash']['type'] ?>">
                <?= htmlspecialchars($_SESSION['flash']['message']) ?>
            </div>

            <?php unset($_SESSION['flash']); ?>

        <?php endif; ?>

        <div class="search-box">

            <label for="search-input">
                Cari Nama Anggota
            </label>

            <input
                type="text"
                id="search-input"
                placeholder="Ketik nama anggota..."
            >

        </div>

        <div class="table-container">

            <table>

                <thead>

                    <tr>
                        <th>No. Anggota</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>No. HP</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody id="tabel-anggota">

                    <?php foreach ($_SESSION['anggota'] as $anggota): ?>

                        <tr>

                            <td>
                                <?= htmlspecialchars($anggota['no_anggota']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($anggota['nama']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($anggota['alamat']) ?>
                            </td>

                            <td>
                                <?= htmlspecialchars($anggota['no_hp']) ?>
                            </td>

                            <td>

                                <button type="button">
                                    Edit
                                </button>

                                <button
                                    type="button"
                                    class="btn-hapus"
                                >
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