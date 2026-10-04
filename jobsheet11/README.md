# Jobsheet 11 — Keamanan Web Dasar (Inventaris HIMA)

**Sub-CPMK:** Menerapkan prinsip keamanan web dasar.
Hardening dari Jobsheet 10 (`auth/`, `barang/`, `peminjaman/`), tanpa fitur baru.

## Perubahan dari Jobsheet 10

- Tambah `includes/helpers.php` (`e()` untuk `htmlspecialchars`) dan `includes/csrf.php` (`csrf_token()`, `csrf_field()`, `csrf_verify()`), keduanya di-`require_once` dari `includes/header.php`.
- Tambah `includes/validasi.php` (`input_int()`, `input_string()`, `input_date()`, `get_id()`, whitelist role/kategori) untuk langkah *validasi & sanitasi input*.
- **XSS:** seluruh output data dari database/`$_GET` (kode & nama barang, nama peminjam, status, nilai pencarian, nama petugas di sidebar, angka/ID) dibungkus `e()`.
- **CSRF:** token tersembunyi ditambahkan ke semua form POST (Tambah/Edit/Hapus Barang & Peminjaman, Kembalikan, Login, Register); setiap `proses_*.php`, `hapus.php`, dan `kembalikan.php` memanggil `csrf_verify()` sebelum menyentuh database.
- **Session fixation:** `session_regenerate_id(true)` dipanggil di `auth/proses_login.php` setelah login berhasil.
- **SQL Injection:** diaudit ulang. Pola query tidak berubah (semua sudah prepared statement PDO sejak jobsheet sebelumnya); ditambah `ATTR_EMULATE_PREPARES => false`.
- **Path relatif otomatis:** `BASE_URL` dihitung di `includes/header.php`, jadi tidak ada lagi path `/jobsheet10/...` yang di-hardcode.
- **Perbaikan bug yang ditemukan saat audit:** `peminjaman/proses_tambah.php` tidak memeriksa login; `kembalikan.php` mengubah data lewat GET (kini POST + token); redirect/link salah path (`/barang/...`, `/peminjaman/...`, `/jobsheet8/...`); `auth/logout.php` tidak ada.
- Tambah `docs/security-checklist.md` — dokumen audit dengan bukti before/after per kerentanan.

## Struktur

```
jobsheet11/
├── includes/
│   ├── header.php        # BARU: BASE_URL, session aman, header keamanan, require helpers+csrf+validasi
│   ├── helpers.php       # BARU: e(), abort_with(), require_post(), require_admin(), handle_db_error()
│   ├── csrf.php          # BARU: csrf_token(), csrf_field(), csrf_verify()
│   ├── validasi.php      # BARU: input_int/string/date, get_id, kategori_exists
│   ├── auth.php          # guard login (memanggil header.php)
│   └── koneksi.php       # PDO pgsql (error tidak lagi bocor ke browser)
├── auth/                 # login, register, proses_*, logout
├── barang/               # list, tambah, edit, proses_tambah, proses_edit, hapus
├── peminjaman/           # list, tambah, edit, proses_tambah, proses_edit, hapus, kembalikan
├── assets/               # css, js (konfirmasi lewat data-confirm, tanpa inline script)
├── data/inventaris.sql
├── docs/security-checklist.md
├── Dokumentasi/README.md
└── README.md
```

## Cara menjalankan

Aplikasi membaca koneksi database dari environment variable: `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`.

**Opsi 1 — PHP built-in server** (jalankan dari dalam folder `jobsheet11/`):

```bash
# Linux / macOS / Git Bash
DB_HOST=... DB_PORT=5432 DB_NAME=postgres DB_USER=... DB_PASSWORD=... php -S localhost:8000
```

```powershell
# PowerShell
$env:DB_HOST="..."; $env:DB_PORT="5432"; $env:DB_NAME="postgres"; $env:DB_USER="..."; $env:DB_PASSWORD="..."; php -S localhost:8000
```

Buka `http://localhost:8000/auth/login.php`.

**Opsi 2 — Laragon (Apache):** virtual host langsung ke folder `jobsheet11/`, atau bersarang di bawah domain proyek (mis. `http://dp2026.test/kode-praktikum/jobsheet-11/`). Path CSS/JS/link/redirect dihitung otomatis oleh `includes/header.php` (konstanta `BASE_URL`), jadi keduanya jalan.

**Opsi 3 — Vercel:** salin blok `JOBSHEET 11` dari `api/index.php` ke router proyekmu, lalu deploy. URL-nya `/jobsheet11/...` dan `BASE_URL` menyesuaikan otomatis. Env var Supabase dari Jobsheet 10 dipakai apa adanya.

Akun `admin` dibuat manual (register selalu membuat `petugas`):

```sql
UPDATE users SET role = 'admin' WHERE username = 'usernamemu';
```

## Cara menguji

Ganti `localhost:8000` sesuai lingkunganmu.

- **CSRF:** login di browser, lalu kirim POST tanpa token:
  `curl -i -X POST http://localhost:8000/barang/proses_tambah.php -d "kode_barang=x" -b "PHPSESSID=<isi cookie>"` → harus **HTTP 403**.
- **XSS:** tambah barang bernama `<script>alert(1)</script>` → di Data Barang tampil sebagai teks, bukan pop-up.
- **Guard order:** `curl -i -X POST http://localhost:8000/barang/proses_tambah.php -d "kode_barang=x"` tanpa login → **302 ke Login** (guard `auth.php` jalan lebih dulu daripada `csrf_verify()`).
- **SQL Injection:** login dengan username `' OR '1'='1` → gagal, kembali ke login.
- **Session fixation:** catat `PHPSESSID` sebelum login, lalu sesudah login → nilainya harus berubah.
- **Kembalikan via URL:** buka `/peminjaman/kembalikan.php?id=1` → **HTTP 405**, data tidak berubah.

## Catatan

Lihat `docs/security-checklist.md` untuk rincian audit, bukti before/after, dan pemetaan tiap kerentanan ke perbaikannya.
