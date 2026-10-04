# Dokumentasi Jobsheet 11 — Keamanan Web Dasar

Melanjutkan Jobsheet 10 (autentikasi & sesi). Fokus: menutup celah dasar tanpa menambah fitur. Rincian audit dan bukti ada di [`../docs/security-checklist.md`](../docs/security-checklist.md); cara menjalankan dan menguji ada di [`../README.md`](../README.md).

## 1. Konsep dasar

Aturan emas: **jangan percaya input**, dan **jangan tampilkan error asli ke pengguna**. Input datang dari `$_GET`, `$_POST`, cookie, dan header. Tiga hal yang selalu dilakukan: validasi di server, query lewat prepared statement, dan escape saat output.

## 2. XSS dan fungsi `e()`

XSS terjadi ketika teks dari pengguna dicetak sebagai HTML. Contoh nama barang `<script>alert(1)</script>` akan dijalankan browser jika dicetak mentah.

```php
function e($value): string {
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
```

Pemakaian: `<?= e($item['nama_barang']) ?>`. `e()` mengubah `<` menjadi `&lt;` sehingga tampil sebagai teks. Aturan: **escape saat output, bukan saat menyimpan.** Lapis kedua: header CSP `script-src 'self'` memblokir skrip inline, itulah sebabnya konfirmasi hapus memakai `data-confirm`, bukan `onclick`.

## 3. CSRF dan token

CSRF: situs lain membuat browser korban (yang sedang login) mengirim request ke aplikasi kita. Cookie session ikut terkirim, sehingga request terlihat sah. Penangkal: token rahasia per session yang hanya diketahui halaman kita.

```php
csrf_token();   // buat/ambil token (bin2hex(random_bytes(32)))
csrf_field();   // <input type="hidden" name="csrf_token" value="...">
csrf_verify();  // hash_equals() ke token session; salah -> 403
```

Urutan di setiap proses: `auth.php` (login) → `require_post()` → `csrf_verify()` → validasi → database. Aksi yang mengubah data harus POST; itulah alasan `kembalikan.php` diubah dari link GET menjadi form POST.

## 4. Session fixation

Penyerang menanam ID session yang ia ketahui sebelum korban login. Jika ID tidak diganti setelah login, penyerang ikut "login". Perbaikan di `auth/proses_login.php`:

```php
session_regenerate_id(true);
```

Pemanggilan hanya setelah `password_verify()` berhasil. Cookie juga diberi `HttpOnly` dan `SameSite=Lax` di `includes/header.php`.

## 5. Audit SQL Injection dan checklist

Pola aman: `$pdo->prepare('... WHERE username = ?')` lalu `execute([$username])`. Pola berbahaya: `$pdo->query("... '$_POST[x]' ...")`. Hasil audit: tidak ditemukan pola berbahaya. Uji `' OR '1'='1` pada login gagal pada versi sebelum maupun sesudah. Detail per berkas ada di `docs/security-checklist.md` bagian 2.

## 6. Rangkuman dan latihan lanjutan

| Ancaman | Penangkal | Berkas |
|---|---|---|
| SQL Injection | prepared statement | semua `proses_*.php`, `list.php` |
| XSS | `e()` + CSP | semua halaman |
| CSRF | `csrf_field()` + `csrf_verify()` | semua form POST |
| Session fixation | `session_regenerate_id(true)` | `auth/proses_login.php` |
| Input liar | `input_int/string/date`, whitelist | `includes/validasi.php` |
| Bocor error | `handle_db_error()`, `error_log` | `includes/helpers.php`, `koneksi.php` |

Latihan lanjutan: (1) batasi percobaan login (mis. 5 kali per 15 menit per username/IP); (2) ubah logout menjadi POST + token; (3) simpan session di database; (4) tambah kolom `dibuat_oleh` pada `peminjaman` dan batasi edit hanya untuk pembuatnya atau admin.
