# Security Checklist — Inventaris HIMA (Jobsheet 11)

Audit kode Jobsheet 7–10 (`auth/`, `barang/`, `peminjaman/`, `includes/`, `index.php`). Tidak ada fitur baru, murni hardening.
Kode **sebelum**: `jobsheet10/`. Kode **sesudah**: `jobsheet11/`.

**Nama / NIM:** ______________________  **Tanggal:** ______________

> **Cara bukti diambil.** Kolom "Sebelum" dan "Sesudah" berisi hasil skrip uji (curl/HTTP) yang dijalankan terhadap kedua versi di PHP 8.3 + PostgreSQL 16 dengan `sslmode=require` (sama seperti `koneksi.php`), memakai skema `data/inventaris.sql`. Hasil "Sebelum" diambil dari kode `jobsheet10/` asli; untuk baris "Fatal error", `display_errors` dinyalakan seperti di Vercel. Kolom "Screenshot" sengaja dikosongkan: ambil sendiri dari browser di hosting-mu (Vercel/Laragon) dan tempel di sini.

---

## 1. Ringkasan temuan

| # | Kerentanan / celah | Tingkat | Status |
|---|---|---|---|
| 1 | Form POST tanpa token CSRF (semua form) | Tinggi | Diperbaiki |
| 2 | `kembalikan.php` mengubah data lewat GET (cukup membuka link) | Tinggi | Diperbaiki |
| 3 | `peminjaman/proses_tambah.php` bisa dipanggil **tanpa login** | Tinggi | Diperbaiki |
| 4 | Session fixation (ID session tidak diganti setelah login) | Sedang | Diperbaiki |
| 5 | Error PDO/PHP tampil ke browser (SQLSTATE, path server) | Sedang | Diperbaiki |
| 6 | Validasi input lemah (jumlah negatif, ID non-angka, kode barang bebas) | Sedang | Diperbaiki |
| 7 | Cookie session tanpa `HttpOnly` / `SameSite` / `Secure` | Sedang | Diperbaiki |
| 8 | Tanpa header keamanan (CSP, X-Frame-Options, nosniff) | Rendah | Diperbaiki |
| 9 | Escape output: nama/keyword sudah aman, tetapi angka/ID tidak di-escape dan flag `htmlspecialchars` tidak eksplisit | Rendah | Diperkuat |
| 10 | Wildcard `%` / `_` pada pencarian bekerja sebagai pola LIKE | Rendah | Diperbaiki |
| 11 | Hapus barang yang masih dipinjam → fatal error (FK) | Rendah | Diperbaiki |
| 12 | Redirect/link salah path (`/barang/...`, `/peminjaman/...`, `/jobsheet8/...`); `auth/logout.php` tidak ada | Bug | Diperbaiki |
| 13 | **SQL Injection** | – | **Tidak ditemukan** (sudah prepared statement) |
| 14 | Tidak ada pembatasan percobaan login (brute force) | Sedang | Belum, lihat bagian 8 |

---

## 2. SQL Injection

**Hasil audit:** tidak ada query yang menggabungkan input ke string SQL. Semua query dengan input user memakai prepared statement PDO. `$pdo->query()` hanya muncul untuk SQL statis tanpa input (`index.php`, daftar kategori, total).

| Berkas | Query dengan input | Sebelum | Sesudah |
|---|---|---|---|
| `auth/proses_login.php` | `WHERE username = ?` | Prepared | Prepared + cek tipe/panjang |
| `auth/proses_register.php` | `SELECT` / `INSERT users` | Prepared | Prepared + whitelist username; role dikunci `petugas` |
| `barang/list.php` | `ILIKE :keyword`, `LIMIT/OFFSET` | Prepared | Prepared + keyword ≤100 karakter, wildcard di-escape |
| `barang/proses_*.php`, `hapus.php` | INSERT / UPDATE / DELETE | Prepared | Prepared + `input_int`/`input_string` + kategori dicek ke DB |
| `barang/edit.php` | `WHERE id_barang = :id` | `id` string mentah | `get_id()` integer positif |
| `peminjaman/*` | SELECT / INSERT / UPDATE / DELETE | Prepared | Prepared + validasi tipe & tanggal, `FOR UPDATE` |

Tambahan: `PDO::ATTR_EMULATE_PREPARES => false` (prepared statement dieksekusi server PostgreSQL, bukan emulasi PDO).

| Uji | Input | Sebelum | Sesudah | Screenshot |
|---|---|---|---|---|
| Login | `' OR '1'='1` | 302 → `login.php?error=1` (gagal) | 302 → `login.php?error=1` (gagal) | [ ] |
| Login | `admin'--` | 302 → `login.php?error=1` (gagal) | 302 → `login.php?error=1` (gagal) | [ ] |
| Pencarian | `' OR 1=1--` | HTTP 200, "tidak ditemukan", tanpa error SQL | sama | [ ] |
| URL edit | `edit.php?id=1 OR 1=1` | **Fatal error: SQLSTATE[22P02]** tampil | 302 → daftar barang, tanpa error | [ ] |

Kesimpulan: **tidak tereksploitasi** pada kedua versi. Yang berubah hanya cara error ditangani (baris terakhir).

---

## 3. XSS

**Hasil audit:** pada Jobsheet 10, nama barang, kode, kategori, nama peminjam, dan keyword pencarian **sudah** dibungkus `htmlspecialchars()`, sehingga payload `<script>` tidak tereksekusi. Celah yang tersisa kecil: output angka/ID (`jumlah`, `id_*`, total dashboard) tidak di-escape, dan flag `ENT_QUOTES` tidak eksplisit. Semua kini lewat `e()` (`ENT_QUOTES | ENT_SUBSTITUTE`, UTF-8), plus CSP `script-src 'self'` sebagai lapis kedua (inline `onclick` dipindah ke `data-confirm`).

| Halaman | Data | Sebelum | Sesudah |
|---|---|---|---|
| `barang/list.php` | kode, nama, kategori, jumlah, keyword | `htmlspecialchars`, `jumlah`/ID mentah | `e()` semua |
| `barang/edit.php`, `tambah.php` | nilai input, opsi kategori | `htmlspecialchars`, angka mentah | `e()` semua |
| `peminjaman/list.php` | nama barang, peminjam, status, tanggal | `htmlspecialchars`, ID mentah | `e()` + `(int)` pada ID |
| `peminjaman/edit.php`, `tambah.php` | nama peminjam, opsi barang, stok | `htmlspecialchars`, stok mentah | `e()` semua |
| `index.php` | nama petugas, role, total | total mentah | `e()` semua |

| Uji | Langkah | Sebelum | Sesudah | Screenshot |
|---|---|---|---|---|
| Nama barang | simpan `<script>alert(1)</script>`, cari "script" | tampil `&lt;script&gt;…`; `<script>` mentah **tidak** ada | sama | [ ] |
| Keyword | cari `"><script>alert(2)</script>` | `<script>` mentah **tidak** ada di HTML | sama | [ ] |

Kesimpulan: **tidak tereksploitasi** pada kedua versi; Jobsheet 11 menutup celah sisa dan menambah CSP.

---

## 4. CSRF

**Perbaikan:** token `bin2hex(random_bytes(32))` di `$_SESSION['csrf_token']` (`csrf_token()`); `csrf_field()` ditempel di semua form POST; `csrf_verify()` (`hash_equals`) dipanggil sebelum menyentuh database. Token salah/kosong → **HTTP 403**. Urutan guard: `auth.php` (login) lebih dulu, baru `csrf_verify()`.

| Berkas | Sebelum | Sesudah |
|---|---|---|
| `barang/hapus.php`, `peminjaman/hapus.php` | admin + POST, tanpa token | admin + POST + token |
| `peminjaman/kembalikan.php` | **GET**, tanpa token | POST + token (GET → 405) |
| `*/proses_tambah.php`, `*/proses_edit.php` | tanpa token | token wajib |
| `auth/proses_login.php`, `proses_register.php` | tanpa token | token wajib |

| Uji | Langkah | Sebelum | Sesudah | Screenshot |
|---|---|---|---|---|
| Hapus tanpa token | login admin, POST `hapus.php` hanya `id_barang` | HTTP 302, **data terhapus** | **HTTP 403**, data tetap ada | [ ] |
| Kembalikan via link | buka `kembalikan.php?id=<id>` | status berubah jadi **Selesai** | **HTTP 405**, status tetap Dipinjam | [ ] |
| POST tanpa `csrf_token` (sudah login) | `curl -b "PHPSESSID=…" -d "kode_barang=NOTOK&nama_barang=y&id_kategori=1&jumlah=1" …/barang/proses_tambah.php` | HTTP 302, **baris masuk DB** | **HTTP 403**, tidak ada baris | [ ] |
| Guard order | POST tanpa login & tanpa token | 302 → login | 302 → login | [ ] |
| Alur normal | form dengan token | – | tambah/edit/hapus/kembalikan berhasil | [ ] |

---

## 5. Validasi & sanitasi input

| Field | Aturan | Fungsi |
|---|---|---|
| `id_*` (POST/GET) | integer positif | `input_int`, `get_id` |
| `jumlah` | integer 0–100000 | `input_int` |
| `kode_barang` | 1–20 karakter; hanya `A-Z a-z 0-9 . _ -` | `input_string` + regex |
| `nama_barang`, `nama_peminjam` | 1–100 karakter, tanpa karakter kontrol | `input_string` |
| `id_kategori` | integer **dan** ada di tabel `kategori` (whitelist dari DB) | `kategori_exists` |
| `tanggal_pinjam` | `YYYY-MM-DD`, tanggal valid | `input_date` |
| `username` | 3–30 karakter; hanya `A-Z a-z 0-9 _` | `input_string` + regex |
| `password` | 8–72 karakter | cek `strlen` |
| `role` | whitelist `admin`/`petugas`; register selalu `petugas`; role tak dikenal di session ditolak | `ROLE_VALID` |
| Input array (`nama[]=x`) | ditolak | cek `is_string` |

| Uji | Input | Sebelum | Sesudah | Screenshot |
|---|---|---|---|---|
| Jumlah negatif | `jumlah=-5` | HTTP 302, **tersimpan -5** di DB | HTTP 422, tidak tersimpan | [ ] |
| Jumlah bukan angka | `jumlah=abc` | **Fatal error SQLSTATE[22P02]** tampil | HTTP 422, pesan umum | [ ] |
| Kode barang dobel | kode sudah ada | **Fatal error SQLSTATE[23505]** tampil | HTTP 409 "Kode barang sudah digunakan." | [ ] |
| Kode berisi simbol | `A B;DROP` | disimpan | HTTP 422 | [ ] |
| Register jahat | username `bad user'--`, password `123` | – | redirect `register.php?error=input` | [ ] |
| Hapus barang yang dipinjam | FK | fatal error | HTTP 409 pesan jelas | [ ] |

---

## 6. Session & autentikasi

| Item | Sebelum | Sesudah |
|---|---|---|
| `session_regenerate_id(true)` setelah login | tidak ada | ada (`auth/proses_login.php`) + token CSRF dibuat ulang |
| Cookie session | default | `HttpOnly`, `SameSite=Lax`, `Secure` saat HTTPS |
| Halaman/proses butuh login | `peminjaman/proses_tambah.php` **tidak** memeriksa login | semua lewat `includes/auth.php` |
| Logout | `auth/logout.php` tidak ada | menghapus session & cookie |

| Uji | Langkah | Sebelum | Sesudah | Screenshot |
|---|---|---|---|---|
| **Session fixation** | tanam `PHPSESSID=attackerfixedsid…` sebelum login, lalu login | ID **tetap sama** (rentan) | ID **berubah** | [ ] |
| Proses tanpa login | POST `peminjaman/proses_tambah.php` tanpa session | HTTP 302, **baris masuk DB** | 302 → login, **tidak ada baris** | [ ] |
| Setelah logout | buka `barang/list.php` | – | 302 → login | [ ] |
| Role | petugas coba hapus barang | 403 | 403 | [ ] |

Cara uji manual di browser: DevTools → Application → Cookies → catat `PHPSESSID`, login, catat lagi.

---

## 7. Penanganan error & header

| Item | Sebelum | Sesudah |
|---|---|---|
| Koneksi DB gagal | `die("… " . $e->getMessage())` (membocorkan host/user) | pesan umum; detail ke `error_log` |
| Error query | `die("… " . $e->getMessage())` / fatal error PDO | `handle_db_error()`: pesan umum; detail ke log |
| Header | tidak ada | `X-Content-Type-Options: nosniff`, `X-Frame-Options: DENY`, `Referrer-Policy`, `Content-Security-Policy` |
| Path aplikasi | `/jobsheet10/...` di-hardcode, sebagian salah | `BASE_URL` otomatis (root, sub-folder, `/jobsheet11`) |

Log error di Vercel: Project → Logs.

---

## 8. Belum ditangani / rekomendasi

- **Brute force login:** belum ada pembatasan percobaan (rate limiting / lockout).
- **Logout via GET:** risiko sangat rendah (hanya memaksa logout), diterima untuk lingkup jobsheet.
- **Session di serverless:** file session PHP di Vercel bersifat sementara; untuk produksi simpan session di database/Redis.
- **Akun admin:** dibuat manual lewat SQL (`UPDATE users SET role = 'admin' …`).

---

## 9. Ringkasan akhir

| Kriteria | Status | Bukti |
|---|---|---|
| Semua query dengan input memakai prepared statement | ☐ | bagian 2 |
| Uji SQL injection pada login gagal (tidak tereksploitasi) | ☐ | bagian 2 |
| Semua output data user di-escape; uji `<script>` tidak tereksekusi | ☐ | bagian 3 |
| Semua form POST memiliki token CSRF dan diverifikasi sebelum DB | ☐ | bagian 4 |
| Validasi input menyeluruh | ☐ | bagian 5 |
| `session_regenerate_id()` setelah login | ☐ | bagian 6 |
