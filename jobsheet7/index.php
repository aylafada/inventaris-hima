<?php
require_once __DIR__. '/includes/init.php';
?>

<?php include __DIR__. '/includes/header.php'; ?>

<main>

    <section>
        <h2>Selamat Datang di SIMPUS-Mini</h2>

        <p>
            Sistem Informasi Manajemen Perpustakaan berbasis web sederhana
        </p>
    </section>

    <section>

        <article>
            <h3>Total Judul Buku</h3>
            <p><?= count($_SESSION['buku']) ?></p>
        </article>

        <article>
            <h3>Total Anggota</h3>
            <p><?= count($_SESSION['anggota']) ?></p>
        </article>

        <article>
            <h3>Buku Dipinjam</h3>
            <p>45</p>
        </article>

    </section>

</main>

<?php include __DIR__. '/includes/footer.php'; ?>