# Jobsheet 4 User flow dan Wireframe 

### Nama : Aylafada Syakira
### Kelas : TI - 2D
### NIM : 254107020116

Jobsheet 4 difokuskan pada perancangan user flow dan wireframe (Login, Dashboard Petugas, Peminjaman, Pengembalian, dan Riwayat) agar menjadi panduan visual terarah sebelum fitur-fitur tersebut diimplementasikan ke dalam kode.

## Aktor
- Tamu :  Melihat katalog buku (`buku/list.html`) dan mencari ketersediaan stok buku
- Petugas : Melakukan otentikasi (Login), Mengakses Dashboard Petugas, dan Mengelola data buku & anggot

## User Flow Peminjaman Buku
[Petugas Login] -> [Dashboard] -> [Pilih menu "Peminjaman Baru"] -> [Pilih/Cari Anggota] -> [Pilih Buku (stok > 0)]  -> [Klik Simpan] -> [Stok buku berkurang 1] -> [Riwayat Tercatat] 

## User Flow Pengembalian Buku
[Dashboard] -> [Menu "Pengembalian"] -> [Cari transaksi aktif (anggota/buku)] -> [Tandai "Dikembalikan"] -> [Stok buku bertambah 1] -> [Kembali ke Dashboard]

## Wireframe Halaman Login Petugas
+--------------------------------------+
|             SIMPUS-Mini              |
|--------------------------------------|
|                                      |
|          [ Login Petugas ]           |
|                                      |
|      Username : [ __________ ]       |
|      Password : [ __________ ]       |
|                                      |
|            [   Masuk   ]             |
|                                      |
|   Belum punya akun? Daftar di sini   |
+--------------------------------------+
Sebagai pintu gerbang autentikasi untuk membatasi hak akses pengelolaan transaksi dan data sensitif perpustakaan agar hanya bisa dioperasikan oleh staf/petugas resmi.
- Form Card: Kontainer form berada tepat di tengah layar (centered layout) berlatar putih dengan bayangan halus.
- Input Fields: Dua kolom input teks untuk ID/email petugas dan kata sandi bertipe password.

## Wireframe Dashboard Petugas
+--------------------------------------------------------------------------+
| SIMPUS-Mini      Beranda  |  Buku  |  Anggota  |  Peminjaman  |  Logout  |
|--------------------------------------------------------------------------|
|  +--------------------+ +--------------------+ +----------------------+  |
|  | Total Buku Tersedia| | Anggota Aktif      | | Sedang Dipinjam      |  |
|  | 144                | | 30                 | | 12                   |  |
|  +--------------------+ +--------------------+ +----------------------+  |
|                                                                          |
|  [ + Peminjaman Baru ]   [ + Pengembalian ]                              |
|                                                                          |
|  Transaksi Terbaru                                                       |
|  ----------------------------------------------------------------------  |
|  Anggota | Buku | Tgl Pinjam | Status                                    |
+--------------------------------------------------------------------------+
Memberikan gambaran umum kondisi sirkulasi koleksi perpustakaan secara cepat kepada petugas setelah berhasil masuk, sekaligus menjadi pusat navigasi ke tugas-tugas harian.
- Navigasi Utama: Menu navigasi di bagian header yang diperluas dengan tautan sirkulasi dan tombol keluar (logout).
- Kartu Statistik (Grid): Tiga kotakuntuk memantau jumlah koleksi buku, anggota, dan buku yang belum dikembalikan.
- Quick Access Shortcuts: Tombol aksi cepat untuk memangkas waktu kerja petugas saat ingin langsung membuka form transaksi tanpa lewat menu dropdown.

## Wireframe Form Peminjaman Buku
+-----------------------------------------------------------------------------+
| SIMPUS-Mini [ Beranda ] [ Buku ] [ Anggota ] [ Peminjaman ] [ Pengembalian ]|
+-----------------------------------------------------------------------------+
|                                                                             |
|  Form Peminjaman Buku                                                       |
|  +-----------------------------------------------------------------------+  |
|  | Pilih Anggota:                                                        |  |
|  | [ A001 - Siti Aminah                                | v ]             |  |
|  |                                                                       |  |
|  | Pilih Judul Buku:                                                     |  |
|  | [ Filosofi Teras (Tersedia: 5)                      | v ]             |  |
|  |                                                                       |  |
|  | Tanggal Pinjam:              Batas Waktu Kembali:                     |  |
|  | [ 06/09/2026 ]               [ 13/09/2026 ]                           |  |
|  |                                                                       |  |
|  | [ Batal ]                    [ Simpan Transaksi ]                     |  |
|  +-----------------------------------------------------------------------+  |
|                                                                             |
+-----------------------------------------------------------------------------+
Mencatat data anggota yang meminjam buku fisik, menentukan batas waktu pengembalian, serta mengurangi stok buku secara otomatis di sistem.
- Dropdown Anggota & Buku: Kolom seleksi anggota aktif dan koleksi buku. Buku dengan stok habis ($0$) otomatis dinonaktifkan (disabled)
- Date Picker: Pemilih tanggal otomatis terisi tanggal hari ini dan tanggal jatuh tempo
- Kotak Notifikasi Edge Case: Area peringatan dinamis (kuning/merah) yang akan muncul jika anggota yang dipilih masih memiliki tunggakan peminjaman buku lama
- Tombol Aksi: Tombol sekunder Batal  dan tombol primer Simpan Transaksi

## Wireframe Pengembalian Buku
+-------------------------------------------------------------------------------+
| SIMPUS-Mini [ Beranda ] [ Buku ] [ Anggota ] [ Peminjaman ] [ Pengembalian ]  |
+-------------------------------------------------------------------------------+
|  Form Pengembalian Buku                                                       |
|  +-------------------------------------------------------------------------+  |
|  | Cari Peminjaman Aktif:                                                  |  |
|  | [ PJ-001 - Siti Aminah (Filosofi Teras)               | v ]             |  |
|  |                                                                         |  |
|  | Tanggal Pengembalian:                                                   |  |
|  | [ 06/09/2026 ]                                                          |  |          
|  |                                                                         |  |
|  | [ Batal ]                    [ Tandai Sudah Dikembalikan ]              |  |
|  +-------------------------------------------------------------------------+  |
Memproses pengembalian fisik buku yang dipinjam, mengalkulasi keterlambatan jika lewat batas waktu, dan mengembalikan kuota stok buku ke katalog.
- Pencarian Transaksi: Dropdown atau kolom input untuk memfilter peminjaman yang berstatus masih berjalan (active loans).
- Tombol Konfirmasi: Tombol Tandai Sudah Dikembalikan untuk menutup transaksi peminjaman tersebut.

## WireFrame Riwayat Peminjaman per Anggota
+-----------------------------------------------------+
|          Riwayat Peminjaman — Siti Aminah           |
|-----------------------------------------------------|
|  Buku            | Pinjam   | Kembali | Status      |
|  Laskar Pelangi  | 01/07    | 10/07   | Selesai     |
|  Bumi Manusia    | 15/07    | -       | Dipinjam    |
+-----------------------------------------------------+
Menjadi arsip pencatatan riwayat sirkulasi transaksi buku untuk audit petugas, memantau siapa saja yang belum mengembalikan buku, serta memantau buku yang sering dipinjam.
- Tabel Data: Menampilkan kode unik transaksi, nama anggota, judul koleksi yang dipinjam, tanggal transaksi, dan status.
- `Status Badges: Label visual berbentuk pil; warna hijau untuk buku yang sudah berstatus [Kembali] dan warna kuning/oranye untuk buku yang statusnya masih [Dipinjam].