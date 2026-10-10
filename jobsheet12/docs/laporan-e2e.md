# Laporan Pengujian End-to-End — Jobsheet 12 (Inventaris HIMA)

Pengujian dijalankan otomatis (curl terhadap aplikasi yang berjalan, dengan PostgreSQL asli) untuk memastikan seluruh alur berfungsi sebagai satu sistem.

**Lingkungan:** PHP 8.3, PostgreSQL 16 dengan `sslmode=require`, dua server PHP terpisah untuk meniru dua instance serverless Vercel.
**Empat cara menjalankan aplikasi, hasil sama (119 / 119):** root (`php -S`), router Vercel (`/jobsheet12`), router `api/index.php` asli milik proyek (tanpa blok tambahan), dan sub-folder (XAMPP `htdocs`).

| Kelompok | Skenario | Lulus |
|---|---|---|
| A | Alur utama sesuai soal: registrasi, login, tambah anggota/barang, pinjam, cek stok, kembalikan, riwayat, dashboard, logout | 43 / 43 |
| B | Aturan terlambat (tugas mandiri), termasuk batas tepat 14 vs 15 hari | 18 / 18 |
| C | Integritas data dan hak akses (FK, role admin, pemulihan stok, edit data lama) | 15 / 15 |
| D | Konkuren: 8 permintaan serentak untuk 1 stok; 6 pengembalian serentak | 6 / 6 |
| E | Keamanan Jobsheet 11 di modul baru (CSRF, XSS, SQL injection, validasi, session lintas instance) | 28 / 28 |
| F | Regresi tautan: setiap link dan aksi di semua halaman tidak 404, redirect benar | 9 / 9 |
| | **Total (per mode)** | **119 / 119** |

Log PHP selama pengujian: 0 warning, 0 notice, 0 error fatal.

## Hasil kunci terhadap kriteria penilaian

| Kriteria | Bukti |
|---|---|
| Stok tidak minus | Pinjam saat stok 0 ditolak (409), stok tetap 0. 8 permintaan serentak untuk 1 stok: tepat 1 berhasil, 7 ditolak, stok 0. Tidak ada barang dengan `jumlah < 0` di akhir pengujian. |
| Stok tidak dobel | Kembalikan dua kali (klik ganda) → kedua ditolak (409), stok tidak bertambah dobel. 6 pengembalian serentak: tepat 1 berhasil, stok kembali +1. |
| Transaksi atomik | Peminjaman yang ditolak tidak meninggalkan baris peminjaman maupun perubahan stok. |
| Alur end-to-end tanpa error | Seluruh langkah kelompok A lulus; transaksi hilang dari daftar aktif setelah dikembalikan dan muncul "Dikembalikan" di riwayat. |
| Beranda real-time | Total Barang, Total Anggota, dan Sedang Dipinjam berubah mengikuti database setelah setiap aksi. |
| Tugas mandiri | Anggota dengan pinjaman aktif lebih dari 14 hari ditolak (409) dan ditandai di dropdown; pinjaman tepat 14 hari belum terlambat; setelah barang dikembalikan, anggota boleh meminjam lagi. |

## Bug yang ditemukan dan perbaikannya

| # | Bug | Cara ditemukan | Perbaikan |
|---|---|---|---|
| 1 | Di halaman modul `anggota/`, alamat dasar salah terhitung sehingga semua link menjadi `/anggota/anggota/list.php` (404) dan redirect setelah simpan salah. Penyebabnya, deteksi `BASE_URL` belum mengenal folder baru `anggota/`. | Uji regresi tautan (kelompok F): mengunjungi semua link/aksi di setiap halaman. Uji status HTTP biasa tidak menangkapnya. | `includes/header.php`: `anggota` ditambahkan ke daftar folder modul pada deteksi `BASE_URL`. Uji F kini lulus di ketiga mode. |
| 2 | `sql/03_peminjaman.sql` dan `data/sessions.sql` gagal di PostgreSQL biasa karena `REVOKE ... FROM anon, authenticated` (role itu hanya ada di Supabase). | Menjalankan skrip di PostgreSQL lokal dengan `ON_ERROR_STOP`. | Perintah dibungkus `DO $$ ... IF EXISTS (SELECT 1 FROM pg_roles WHERE rolname = 'anon')`, sehingga jalan di Supabase maupun Postgres lokal. |
| 3 | Pengembalian lewat link GET (`kembali.php?id=...`) dapat dipicu dari situs lain (CSRF), dan di versi awal link menunjuk nama berkas yang salah (404). | Audit Jobsheet 10-11. | Pengembalian hanya lewat POST + token CSRF ke `proses_kembali.php`. Halaman tujuan setelah proses memakai whitelist (`dari=kembali|list`), bukan URL dari input, sehingga tidak ada open redirect. |
| 4 | Dua session berbeda (Jobsheet 10 dan 11/12) memakai nama cookie `PHPSESSID` yang sama di domain yang sama, sehingga login di satu jobsheet bisa mengeluarkan login di jobsheet lain. | Analisis alur cookie saat merancang migrasi. | Jobsheet 12 memakai nama cookie `inv12_sid`. |

Catatan kompatibilitas: setelah `sql/03_peminjaman.sql` dijalankan, kode Jobsheet 10 dan Jobsheet 11 asli diuji ulang pada database yang sama (lihat daftar, tambah peminjaman, kembalikan) dan tetap berfungsi tanpa error. Migrasi hanya menambah kolom `id_anggota` (nullable) dan tabel `anggota`.

## Yang perlu kamu lengkapi sendiri

Pengujian di atas dijalankan otomatis di lingkungan lokal. Untuk laporan, ulangi alur pada bagian "Pengujian end-to-end yang disarankan" di README di browser pada hosting-mu (Vercel/XAMPP), lalu tempel screenshot tiap langkah:

| Langkah | Screenshot |
|---|---|
| Tambah anggota dan barang | [ ] |
| Peminjaman Baru, stok barang berkurang | [ ] |
| Dashboard "Sedang Dipinjam" bertambah | [ ] |
| Pengembalian, transaksi hilang dari daftar aktif | [ ] |
| Riwayat anggota (status Dikembalikan) | [ ] |
| Aturan terlambat menolak peminjaman (tugas mandiri) | [ ] |
| Uji stok 0: barang tidak muncul di dropdown | [ ] |
