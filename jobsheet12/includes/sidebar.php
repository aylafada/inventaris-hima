<?php

/*
| Sidebar bersama (dipakai halaman anggota & riwayat).
| Isi $menuAktif sebelum require:
|   'dashboard' | 'barang' | 'anggota' | 'peminjaman' | 'baru' | 'kembali' | 'riwayat'
*/
$menuAktif = $menuAktif ?? '';

function menu_class(string $nama, string $aktif): string
{
    return $nama === $aktif ? ' class="active"' : '';
}
?>
    <aside class="sidebar">

        <h2>Inventaris HIMA</h2>

        <p class="sidebar-subtitle">Sistem Inventaris</p>

        <div class="user-info">
            <strong><?= e($_SESSION['nama']) ?></strong>
            <span><?= e($_SESSION['role']) ?></span>
            <a href="<?= BASE_URL ?>/auth/logout.php">Logout</a>
        </div>

        <nav>
            <a href="<?= BASE_URL ?>/index.php"<?= menu_class('dashboard', $menuAktif) ?>>Dashboard</a>
            <a href="<?= BASE_URL ?>/barang/list.php"<?= menu_class('barang', $menuAktif) ?>>Data Barang</a>
            <a href="<?= BASE_URL ?>/anggota/list.php"<?= menu_class('anggota', $menuAktif) ?>>Data Anggota</a>
            <a href="<?= BASE_URL ?>/peminjaman/list.php"<?= menu_class('peminjaman', $menuAktif) ?>>Data Peminjaman</a>
            <a href="<?= BASE_URL ?>/peminjaman/tambah.php"<?= menu_class('baru', $menuAktif) ?>>Peminjaman Baru</a>
            <a href="<?= BASE_URL ?>/peminjaman/kembali.php"<?= menu_class('kembali', $menuAktif) ?>>Pengembalian</a>
            <a href="<?= BASE_URL ?>/peminjaman/riwayat.php"<?= menu_class('riwayat', $menuAktif) ?>>Riwayat</a>
        </nav>

    </aside>
