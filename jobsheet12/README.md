# Jobsheet 12 — Integrasi Modul Peminjaman (Inventaris HIMA)

**Sub-CPMK:** Mengintegrasikan front-end dan back-end proyek secara utuh.

**Keterkaitan:** Melengkapi modul Peminjaman & Pengembalian yang menghubungkan tabel `barang`, `anggota`, dan `users` (Jobsheet 8-11), lalu menguji seluruh aplikasi sebagai satu sistem.

## Perubahan dari Jobsheet 11

- Tambah `sql/03_peminjaman.sql`: tabel `anggota` dan kolom `peminjaman.id_anggota` (foreign key). Tabel `barang` dan `peminjaman` sudah ada sejak Jobsheet 10, jadi skrip ini **hanya menambah** (tidak menghapus/mengubah data lama) dan boleh dijalankan berulang.
- Tambah modul **Anggota** (`anggota/list.php`, `tambah.php`, `edit.php`, `proses_tambah.php`, `proses_edit.php`, `hapus.php`). Di Inventaris HIMA sebelumnya peminjam hanya diketik bebas (`nama_peminjam`), sehingga dropdown anggota membutuhkan tabelnya.
- Modul **Peminjaman** yang menghubungkan seluruh entitas:
  - `peminjaman/tambah.php` + `proses_tambah.php`: pilih anggota + barang (dropdown barang hanya `jumlah > 0`), simpan transaksi dan kurangi stok dalam satu transaction (`beginTransaction` / `commit` / `rollBack`) dengan `SELECT ... FOR UPDATE` untuk mencegah race condition stok.
  - `peminjaman/kembali.php` + `proses_kembali.php`: daftar transaksi aktif (`status = 'Dipinjam'`), tombol Kembalikan menambah kembali stok dalam transaction serupa.
  - `peminjaman/riwayat.php`: histori peminjaman per anggota (JOIN `peminjaman` + `barang` + `anggota`).
- `includes/sidebar.php`: menu Data Anggota, Peminjaman Baru, Pengembalian, Riwayat (hanya tampil saat login).
- `index.php`: kartu **Total Anggota** (baru) dan **Sedang Dipinjam** memakai `COUNT(*)` real dari database.
- `includes/header.php`: deteksi `BASE_URL` mengenali folder `anggota/`, dan nama cookie session khusus `inv12_sid` agar tidak saling menimpa session Jobsheet 10/11 di domain yang sama.
- **Tugas mandiri (sudah dikerjakan):** anggota dengan peminjaman aktif lebih dari 14 hari tidak bisa meminjam barang baru. Aturan dicek di server (dalam transaksi), dan di dropdown anggota tersebut ditandai "terlambat" serta dinonaktifkan.

### Penyesuaian dari contoh simpus-mini

| simpus-mini | Inventaris HIMA |
|---|---|
| `buku`, `stok` | `barang`, `jumlah` |
| `status = 'dipinjam'` | `'Dipinjam'` (huruf besar, mengikuti data Jobsheet 10 yang sudah ada) |
| status "Selesai" | disimpan `'Selesai'`, **ditampilkan "Dikembalikan"** |
| navbar di `includes/header.php` | `includes/sidebar.php` (proyek ini tidak punya layout bersama) |
| `tanggal_kembali = now()` | `CURRENT_DATE` (kolomnya bertipe `DATE`) |

## Cara menjalankan

### 1. Siapkan database

**Supabase** → SQL Editor, jalankan berurutan (masing-masing sekali):

1. `data/sessions.sql` (lewati jika sudah pernah dijalankan di Jobsheet 11)
2. `sql/03_peminjaman.sql`

Aman untuk situs Jobsheet 10 dan 11 yang sedang berjalan: tidak ada kolom atau data yang dihapus. Baris peminjaman lama tetap tampil (ditandai "data lama, belum terhubung ke anggota"); isi anggotanya lewat **Edit** peminjaman.

**PostgreSQL lokal:** `psql -d inventaris -f sql/03_peminjaman.sql`. Untuk instalasi dari nol pakai `data/inventaris.sql` (sudah memuat tabel `anggota`), lalu `data/sessions.sql`.

### 2. Jalankan aplikasi

Set environment variable koneksi database (sama seperti Jobsheet 10/11): `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`. Untuk PostgreSQL lokal tanpa SSL tambahkan `DB_SSLMODE=disable`.

**Opsi 1 — PHP built-in server** (paling mudah, termasuk di XAMPP):

```
cd jobsheet12
php -S localhost:8000
```

Windows (cmd): `set DB_HOST=...` sebelum `php -S`. PowerShell: `$env:DB_HOST="..."`.

**Opsi 2 — XAMPP (Apache):** letakkan folder di `htdocs/jobsheet12/` lalu buka `http://localhost/jobsheet12/`. Aktifkan `extension=pdo_pgsql` dan `extension=pgsql` di `php.ini`, set variabel `DB_*` sebagai environment variable Windows, lalu restart Apache. `BASE_URL` menyesuaikan otomatis.

**Opsi 3 — Vercel:** lihat bagian berikut.

### Deploy ke Vercel dengan aman

Jangan langsung push ke `main`. Kerjakan di branch terpisah supaya link yang sedang hidup tidak berubah:

1. Jalankan SQL di langkah 1 (aman).
2. Buat branch dari commit yang sedang hidup: `git checkout -b jobsheet12-fix <KODE_COMMIT>`.
3. Salin folder `jobsheet12/` ke repo dan perbarui `index.html` (kartu Jobsheet 12). **`api/index.php` tidak perlu diubah**: router bawaanmu sudah melayani semua folder `jobsheetN` secara otomatis (diuji pada router aslimu).
4. `git add -A`, `git status` (pastikan tidak ada baris `deleted:`), `git commit`, `git push -u origin jobsheet12-fix`.
5. Uji di alamat **Preview** yang dibuat Vercel (variabel `DB_*` harus dicentang untuk **Preview**). Jika sudah beres, **Promote to Production**.

## Pengujian end-to-end yang disarankan

Registrasi petugas → Login → Tambah Barang & Anggota → Peminjaman Baru → cek stok barang berkurang di Data Barang → cek kartu "Sedang Dipinjam" di Dashboard bertambah → Pengembalian → cek stok kembali bertambah dan transaksi hilang dari daftar aktif → Riwayat (pilih anggota) → transaksi muncul berstatus "Dikembalikan" → Logout.

Hasil pengujian otomatis (119 skenario, termasuk uji serentak, termasuk lewat router `api/index.php` asli) dan bug yang ditemukan ada di `docs/laporan-e2e.md`.

## Catatan

- Operasi stok memakai `SELECT ... FOR UPDATE` di dalam transaction, ditambah syarat `WHERE jumlah > 0` pada `UPDATE`, sehingga stok tidak bisa negatif walau dua peminjaman diproses hampir bersamaan.
- Pengamanan Jobsheet 11 (CSRF, validasi input, escape output, session di database) tetap berlaku di semua modul baru. Pengembalian hanya lewat POST + token CSRF, bukan link.
- Akun `admin` dibuat manual: `UPDATE users SET role = 'admin' WHERE username = '...';` (hanya admin yang bisa menghapus data).
