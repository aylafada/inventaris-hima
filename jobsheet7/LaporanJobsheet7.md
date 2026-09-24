# LAPORAN JOBSHEET 7 Desain Pemrograman Web

#### Nama  : Aylafada Syakira
#### Kelas : TI-2D
#### NIM   : 254107020116

## 1. Perubahan dari HTML ke PHP 
Pada Jobsheet 7, halaman yang sebelumnya menggunakan `.html` diubah menjadi `.php` agar dapat diproses oleh server.
Beberapa perubahan yang dilakukan adalah:
- Mengubah file `index.html`, `buku/list.html`, `buku/tambah.html`, `anggota/list.html`, dan `anggota/tambah.html` menjadi file `.php`.
- Membuat `header.php` dan `footer.php` di dalam folder `includes` supaya bagian header dan footer tidak perlu ditulis berulang kali.
- Menyesuaikan path CSS dan link navigasi karena posisi file PHP berada di folder yang berbeda.
- Mengubah form tambah buku dan anggota agar datanya dikirim menggunakan metode `POST`.

Contoh pada form tambah buku:
```html
<form method="post" action="proses_tambah.php">
```

Dengan cara ini, data yang dimasukkan pengguna akan dikirim ke PHP untuk diproses di server

## 2. Server-Side Validation 
Pada Jobsheet 7, validasi tidak hanya dilakukan menggunakan JavaScript, tetapi juga dilakukan menggunakan PHP.
Data dari form diambil menggunakan `$_POST`.
```php
$judul = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun = $_POST['tahun'] ?? '';
$stok = $_POST['stok'] ?? '';
```

Kemudian dilakukan pengecekan terhadap data yang diterima.
Beberapa validasi yang diterapkan:
- Judul wajib diisi.
- Pengarang wajib diisi.
- Tahun harus berupa angka dan berada di antara 1900–2026.
- Stok harus berupa angka dan tidak boleh negatif.

Contohnya:
```php
if (!is_numeric($stok) || $stok < 0) {
    $errors[] = "Stok tidak boleh negatif.";
}
```

## 3. Session dan Flash Message 
Pada Jobsheet 7 digunakan `$_SESSION` untuk menyimpan data buku dan anggota secara sementara.
Contohnya:
```php
$_SESSION['buku'][] = [
    'judul' => $judul,
    'pengarang' => $pengarang,
    'tahun' => (int) $tahun,
    'stok' => (int) $stok
];
```

Data yang berhasil ditambahkan kemudian dapat ditampilkan kembali pada halaman `list.php` menggunakan `foreach`.
Selain untuk menyimpan data, session juga digunakan untuk membuat **flash message**.

Contohnya:
```php
$_SESSION['flash'] = [
    'type' => 'success',
    'pesan' => 'Buku berhasil ditambahkan.'
];
```

Flash message digunakan untuk memberikan informasi kepada pengguna apakah proses berhasil atau terdapat kesalahan.

## 4. Modifikasi 
Beberapa modifikasi yang dilakukan pada Jobsheet 7 adalah:
- Mengubah halaman dari HTML menjadi PHP.
- Membuat `includes/header.php` dan `includes/footer.php`.
- Membuat `proses_tambah.php` untuk buku dan anggota.
- Menggunakan `$_POST` untuk menerima data form.
- Menggunakan `$_SESSION` sebagai penyimpanan data sementara.
- Menggunakan `foreach` untuk menampilkan data dari session ke tabel.
- Menghapus proses `fetch()` data JSON dari Jobsheet 6 karena data sudah diproses menggunakan PHP.
- Menyesuaikan JavaScript agar validasi client-side tidak menghalangi proses submit ke PHP.
- Menambahkan validasi server-side pada data buku dan anggota.

## 5. Pengujian 
Pengujian dilakukan untuk memastikan proses server-side berjalan dengan benar.

### a. Menambah data buku
Data buku diisi dengan data yang valid kemudian tombol **Simpan** ditekan.
Hasil:  Data berhasil disimpan dan muncul pada halaman daftar buku.

### b. Mengosongkan form
Form buku dikosongkan kemudian tombol **Simpan** ditekan.
Hasil: Data ditolak dan muncul pesan bahwa field wajib diisi.

### c. Memasukkan stok negatif
Stok diisi dengan nilai `-5`.
Hasil: Data ditolak karena stok tidak boleh negatif.

### d. Memasukkan tahun yang tidak sesuai
Tahun diisi dengan `1800`.
Hasil: Data ditolak karena tahun harus berada pada rentang 1900–2026.

### e. Pengujian tanpa JavaScript
JavaScript pada browser dinonaktifkan kemudian form kosong dikirim.
Hasil: Data tetap ditolak oleh PHP. Hal ini membuktikan bahwa validasi server-side tetap berjalan tanpa bantuan JavaScript.

## 6. Kesimpulan 
Kesimpulan dari praktikum Jobsheet 7 ini adalah PHP dapat digunakan untuk mengolah data dari form pada sisi server. Data yang dikirim menggunakan metode `POST` dapat divalidasi terlebih dahulu sebelum disimpan ke dalam `$_SESSION`, kemudian ditampilkan kembali menggunakan `foreach`. Selain itu, penggunaan server-side validation membuat sistem tetap dapat menolak data yang tidak valid meskipun JavaScript pada browser dinonaktifkan.
