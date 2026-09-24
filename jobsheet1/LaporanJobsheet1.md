# LAPORAN JOBSHEET 1 Desain dan Pemrograman Web

### Nama : Aylafada Syakira
### Kelas : TI - 2D
### NIM : 254107020116

## index.html (Halaman Beranda)
File index.html merupakan halaman utama dari aplikasi SIMPUS-Mini. File ini menjadi halaman pertama yang dibuka ketika aplikasi dijalankan karena index.html merupakan nama baku yang umunya dicari oleh browser atau server sebagai halaman utama sebuat folder

### Penjelasan Perbaris
1. `<!DOCTYPE html> <>` 
mendeklarasikan bahwa dokumen menggunakan standar HTML5
2. `<html lang="id">` 
menjadi elemen utama yang membungkus seluruh dokumen HTML Atribut lang="id" menunjukkan bahwa bahasa utama halaman adalah Bahasa Indonesia
3. `<head>` 
Membuka bagian `<head>` yang berisi informasi dan pengaturan halaman yang digunakan oleh browser.
4. `<meta charset="UTF-8">` 
Menentukan penggunaan karakter UTF-8 agar berbagai karakter dan simbol dapat ditampilkan dengan benar.
5. `<title>SIMPUS-Mini | Beranda</title>` 
Menentukan judul halaman yang ditampilkan pada tab browser
6. `</head>`  
Menandai akhir dari bagian `<head>`.
7. `<body>` 
Membuka bagian `<body>` yang berisi seluruh konten yang ditampilkan kepada pengguna.
8. `<header>` 
Membuka bagian kepala halaman yang berisi identitas aplikasi dan menu navigasi.
9. `<h1>SIMPUS-Mini</h1>` 
Menampilkan judul utama aplikasi. `<h1>` merupakan heading dengan tingkat paling tinggi dan setiap halaman HTML sebaiknya memiliki satu `<h1>` utama.
10. `<nav>` 
Membuka bagian navigasi yang digunakan untuk mengelompokkan menu perpindahan halaman 
11. `<ul>` 
Membuat unordered list atau daftar tak berurutan untuk membungkus seluruh item menu navigasi
12. `<li><a href="index.html">Beranda</a><li>` Membuat satu item menu bernama Beranda. Tag `<a>` digunakan sebagai tautan, sedangkan href="index.html" menentukan halaman tujuan.
13. `<li><a href="buku/list.html">Daftar Buku</a></li>` 
Membuat item menu Daftar Buku yang mengarah ke file list.html di dalam folder buku.
14. `<li><a href="buku/tambah.html">Tambah Buku</a></li>` 
Membuat item menu Tambah Buku yang mengarah ke file tambah.html di dalam folder buku.
15. `<li><a href="anggota/list.html">Daftar Anggota</a></li>` 
Membuat item menu Daftar Anggota yang mengarah ke file list.html di dalam folder anggota.
16. `<li><a href="anggota/tambah.html">Daftar Anggota</a></li>` 
Membuat item menu Tambah Anggota yang mengarah ke file tambah.html di dalam folder anggota.
17. `</ul>` 
Menandai akhir dari daftar menu yang dibuat menggunakan `<ul>`.
18. `</nav>` 
Menandai akhir dari bagian navigasi
19. `</header>` 
Menandai akhir dari bagian kepala halaman 
20. `<main>` 
Membuka bagian konten utama halaman 
21. `<section>` 
Membuka bagian pertama dalam konten utama yang digunakan untuk mengelompokkan informasi berdasarkan topik
22. `<h2>Selamat Datang di Sistem Perpustakaan Mini</h2>` 
Menampilkan judul section pertama. `<h2>` digunakan sebagai heading yang tingkatnya berada di bawah `<h1>`.
23. `<p>Aplikasi sederhana untuk mengelola data buku dan anggota perpustakaan.</p>` 
Menampilkan paragraf yang menjelaskan fungsi aplikasi SIMPUS-Mini.
24. `</section>` 
Menandai akhir dari section pertama.
25. `<section>` 
Membuka section kedua yang digunakan untuk menampilkan ringkasan statistik perpustakaan.
26. `<h2>Ringkasan</h2>` 
Menampilkan judul untuk bagian ringkasan statistik.
27. `<article>`
Membuka article pertama yang digunakan untuk menampilkan satu informasi statistik yang dapat berdiri sendiri.
28. `<h3>Total Buku</h3>` 
Menampilkan judul statistik yang menunjukkan jumlah keseluruhan buku. `<h3>` berada satu tingkat di bawah `<h2>`.
29. `<p>12</p>` 
Menampilkan angka 12 sebagai contoh jumlah buku. Angka ini masih merupakan data dummy yang ditulis secara manual.
30. `</article>` 
Menandai akhir dari article pertama.
31. `<article>` 
Membuka article kedua menampilkan informasi jumlah anggota perpustakaan
32. `<h3>Total Anggota</h3>` 
Menampilkan judul statistik jumlah anggota perpustakaan.
33. `<p>8</p>` 
Menampilkan angka 8 sebagai contoh jumlah anggota. Angka ini masih berupa data dummy dan belum berasal dari database.
34. `</article>`
Menandai akhir dari article kedua.
35. `<article>`
Membuka article ketiga untuk menampilkan informasi jumlah buku yang sedang dipinjam.
36. `<h3>Sedang Dipinjam</h3>`
Menampilkan judul statistik jumlah buku yang sedang dipinjam.
37. `<p>3</p>` 
Menampilkan angka 3 sebagai contoh jumlah buku yang sedang dipinjam. Angka ini masih berupa data dummy.
38. `</article>` 
Menandai akhir dari article ketiga.
39. `</section>` 
Menandai akhir dari section Ringkasan.
40. `</main>` 
Menandai akhir dari bagian konten utama halaman.
41. `<footer>` 
Membuka bagian footer atau kaki halaman yang digunakan untuk menampilkan informasi tambahan.
42. `<p>&copy; 2026 SIMPUS-Mini &mdash; Jobsheet 1</p>` 
Menampilkan informasi copyright. &copy; merupakan HTML entity untuk simbol ©, sedangkan &mdash; merupakan entity untuk tanda pisah panjang —.
43. `</footer>` 
Menandai akhir dari bagian footer.
44. `</body>` 
Menandai akhir dari seluruh konten yang ditampilkan pada halaman.
45. `</html>` 
Menandai akhir dari keseluruhan dokumen HTML.

### Penjelasan Struktur Semantic HMTL
Halaman index.html menggunakan beberapa elemen semantic HTML5. Elemen - elemen tersebut digunakan untuk memberikan makna yang jelas terhadap struktur halaman
- `<header>` digunakan sebagai kepala halaman yang berisi identitas aplikasi dan navigasi.
- `<nav>` digunakan untuk bagian menu navigasi.
- `<main>` digunakan untuk menampung konten utama halaman.
- `<section>` digunakan untuk mengelompokkan konten berdasarkan topik tertentu.
- `<article>` digunakan untuk informasi yang dapat berdiri sendiri. Pada halaman ini, setiap article digunakan sebagai satu bagian statistik.
- `<footer>` digunakan sebagai bagian kaki halaman untuk menampilkan informasi tambahan seperti copyright

Pada bagian navigasi, `<ul>` digunakan untuk membungkus daftar menu, sedangkan setiap `<li>` menjadi satu item menu yang berisi tautan `<a>`. Atribut href pada setiap tautan menentukan halaman tujuan. Karena index.html berada di folder root, path menuju folder buku/ dan anggota/ dapat ditulis secara langsung tanpa menggunakan ../

### Kesimpulan 
File index.html merupakan halaman beranda yang menerapkan struktur HTML5 semantic. Struktur dasar halaman terdiri dari `<header>` yang berisi judul dan navigasi, `<main>` yang berisi konten utama halaman, serta `<footer>` yang berisi informasi copyright.
Struktur tersebut menjadi pola dasar yang akan digunakan pada halaman lainnya dalam jobsheet. Perbedaan utama antarhalaman terdapat pada isi `<main>`, sedangkan bagian `<header>` dan `<footer>` dapat dibuat dengan struktur yang konsisten. Dengan memahami struktur index.html, pembuatan halaman buku/list.html, buku/tambah.html, anggota/list.html, dan anggota/tambah.html menjadi lebih mudah karena menggunakan konsep semantic HTML yang sama.

## buku/list.html (Daftar Buku)
File buku/html merupakan halaman Daftar Buku pada aplikasi SIMPUS-Mini. Halaman ini digunakan untuk menampilkan data buku dalam bentuk tabel. Data yang ditampilkan masih berupa contoh atau data statis, yaitu sebanyak 5 baris data buku

### Penjelasan Perbaris
1. `<table>`
Baris ini membuka elemen tabel utama untuk menampung seluruh struktur baris dan kolom data buku.
2. `<thead>`
Baris ini membuka area kepala tabel yang berfungsi mengelompokkan baris judul kolom.
3. `<tr>`
Baris ini mendefinisikan baris pertama di dalam kepala tabel.
4. `<th>Judul</th>`
Baris ini membuat sel judul kolom untuk nama atau judul buku.
5. `<th>Pengarang</th>`
Baris ini membuat sel judul kolom untuk nama penulis atau pengarang buku.
6. `<th>Tahun</th>`
Baris ini membuat sel judul kolom untuk tahun terbit buku.
7. `<th>Stok</th>`
Baris ini membuat sel judul kolom untuk jumlah ketersediaan stok buku.
8. `<th>Aksi</th>`
Baris ini membuat sel judul kolom untuk penempatan tombol operasi data.
9. `</tr>`
Baris ini merupakan tag penutup untuk baris pada kepala tabel.
10. `</thead>`
Baris ini menandai akhir dari blok kepala tabel.
11. `<tbody>`
Baris ini membuka area badan tabel yang berfungsi menampung seluruh baris data rekaman buku.
12. `<tr>`
Baris ini membuka baris data untuk rekaman buku (pola ini diulang untuk setiap data buku: *Bumi Manusia*, *Cantik Itu Luka*, *Laut Bercerita*, *Negeri 5 Menara*, dan *Atomic Habits*).
13. `<td>Bumi Manusia</td>`
Baris ini menampilkan sel data untuk judul buku pada baris yang bersangkutan.
14. `<td>Pramoedya Ananta Toer</td>`
Baris ini menampilkan sel data untuk nama pengarang buku.
15. `<td>2012</td>`
Baris ini menampilkan sel data untuk tahun terbit buku.
16. `<td>4</td>`
Baris ini menampilkan sel data untuk jumlah stok buku yang tersedia.
17. `<td>`
Baris ini membuka sel kolom aksi yang menampung tombol-tombol interaksi data.
18. `<button type="button">Edit</button>`
Baris ini membuat tombol dengan label "Edit" bertipe standar untuk persiapan fungsi pembaruan data.
19. `<button type="button">Hapus</button>`
Baris ini membuat tombol dengan label "Hapus" bertipe standar untuk persiapan fungsi penghapusan data.
20. `</td>`
Baris ini merupakan tag penutup untuk sel kolom aksi.
21. `</tr>`
Baris ini merupakan tag penutup untuk satu baris data buku.

### Kesimupulan 
File buku/list.html merupakan halaman yang digunakan untuk menampilkan daftar buku pada aplikasi SIMPUS-Mini. Halaman ini menggunakan struktur HTML5 semantic berupa `<header>`, `<nav>`, `<main>`, `<section>`, dan `<footer>`. Perbedaan utama terdapat pada `<main>`, yaitu penggunaan elemen `<table>` untuk menampilkan data buku. Tabel terdiri dari lima kolom, yaitu Judul, tahun, stok, pengararang, dan aksi, serta lima baris data dummy

## buku/tambah.html (Form Tambah Buku)
File ini menampilkan form (formulir isian) untuk menambah data buku baru. ini adalah file pertama di jobsheet ini yang memperkenalkan elemen `<form>` dan berbagai jenis `<input>`

### Penjelasan Perbaris
1. `<form>`
Baris ini merupakan tag pembuka form yang berfungsi sebagai wadah untuk membungkus semua elemen input agar dapat dikirimkan secara bersamaan saat tombol simpan ditekan.
2. `<p>`
Baris ini membuka elemen paragraf untuk membungkus label dan input judul agar tersusun rapi serta terpisah dari baris isian lainnya.
3. `<label for="judul">Judul</label><br>`
Baris ini menampilkan teks label "Judul" yang dihubungkan ke input dengan `id="judul"` melalui atribut `for`, serta tag `<br>` untuk memindahkan posisi input ke baris berikutnya.
4. `<input type="text" id="judul" name="judul" required>`
Baris ini membuat kotak input teks wajib diisi (`required`) untuk judul buku dengan identitas `id="judul"` serta nama variabel `name="judul"` saat dikirim ke server.
5. `</p>`
Baris ini merupakan tag penutup paragraf untuk area isian judul buku.
6. `<p>`
Baris ini membuka elemen paragraf untuk kelompok isian pengarang buku.
7. `<label for="pengarang">Pengarang</label><br>`
Baris ini menampilkan teks label "Pengarang" yang terhubung ke input ber-`id="pengarang"`, diikuti line break `<br>`.
8. `<input type="text" id="pengarang" name="pengarang" required>`
Baris ini membuat kotak isian teks wajib diisi (`required`) untuk nama pengarang buku.
9. `</p>`
Baris ini merupakan tag penutup paragraf untuk area isian pengarang.
10. `<p>`
Baris ini membuka elemen paragraf untuk kelompok isian tahun terbit.
11. `<label for="tahun">Tahun Terbit</label><br>`
Baris ini menampilkan teks keterangan "Tahun Terbit" yang terhubung dengan input ber-`id="tahun"`, disertai `<br>` untuk membuat baris baru.
12. `<input type="number" id="tahun" name="tahun" min="1900" max="2026" required>`
Baris ini menyediakan input bertipe angka wajib diisi dengan batasan nilai minimal tahun 1900 dan maksimal tahun 2026.
13. `</p>`
Baris ini merupakan tag penutup paragraf untuk kelompok isian tahun terbit.
14. `<p>`
Baris ini membuka elemen paragraf untuk kelompok isian ISBN.
15. `<label for="isbn">ISBN</label><br>`
Baris ini menampilkan teks label "ISBN" yang terhubung ke input ber-`id="isbn"`, diikuti tag pemindah baris `<br>`.
16. `<input type="text" id="isbn" name="isbn">`
Baris ini membuat kotak input teks opsional (boleh dikosongkan karena tidak ada atribut `required`) untuk memasukkan nomor ISBN.
17. `</p>`
Baris ini merupakan tag penutup paragraf untuk area isian ISBN.
18. `<p>`
Baris ini membuka elemen paragraf untuk kelompok isian jumlah stok buku.
19. `<label for="stok">Stok</label><br>`
Baris ini menampilkan teks label "Stok" yang terhubung ke input `id="stok"`, diikuti tag `<br>`.
20. `<input type="number" id="stok" name="stok" min="0" required>`
Baris ini membuat input angka wajib diisi untuk stok buku dengan nilai minimal 0 agar tidak bernilai negatif.
21. `</p>`
Baris ini merupakan tag penutup paragraf untuk area isian stok.
22. `<p>`
Baris ini membuka elemen paragraf untuk kelompok pilihan kategori buku.
23. `<label for="kategori">Kategori</label>`
Baris ini menampilkan teks label "Kategori" yang terhubung ke elemen `<select>` ber-`id="kategori"`.
24. `<select id="kategori" name="kategori">`
Baris ini membuat menu dropdown pemilihan kategori buku dengan identitas elemen `kategori`.
25. `<option value="fiksi">Fiksi</option>`
Baris ini menyediakan opsi dropdown pertama bertuliskan "Fiksi" yang akan mengirimkan nilai `fiksi` ke server sekaligus menjadi pilihan default.
26. `<option value="non-fiksi">Non-Fiksi</option>`
Baris ini menyediakan opsi dropdown kedua bertuliskan "Non-Fiksi" dengan nilai kirim `non-fiksi`.
27. `<option value="referensi">Referensi</option>`
Baris ini menyediakan opsi dropdown ketiga bertuliskan "Referensi" dengan nilai kirim `referensi`.
28. `</select>`
Baris ini merupakan tag penutup untuk elemen menu dropdown pilihan kategori.
29. `</p>`
Baris ini merupakan tag penutup paragraf untuk kelompok isian kategori.
30. `<p>`
Baris ini membuka elemen paragraf untuk tombol submit form.
31. `<button type="submit">Simpan</button>`
Baris ini membuat tombol "Simpan" bertipe submit yang berfungsi untuk memicu pengiriman seluruh data form saat diklik.
32. `</p>`
Baris ini merupakan tag penutup paragraf untuk tombol submit.
33. `</form>`
Baris ini menandai akhir dari seluruh blok formulir HTML.

### Kesimpulan
Kode pada file `buku/tambah.html` berfungsi untuk menyusun antarmuka formulir penambahan data buku baru dengan memanfaatkan elemen dasar `<form>`, pengelompokan `<p>`, pasangan `<label>` dan `<input>`, serta menu dropdown `<select>`. Struktur ini menerapkan validasi bawaan HTML5 (seperti atribut `required`, `min`, dan `max`) untuk menjaga kevalidan format data tanpa memerlukan script tambahan. Penggunaan atribut `for` pada label yang dipasangkan dengan `id` pada input juga meningkatkan aksesibilitas formulir, sedangkan atribut `name` disiapkan untuk membawa parameter data saat nantinya dihubungkan ke sistem backend.

## anggota/list.html
File anggota/list.html berfungsi untuk menampilkan data daftar anggota perpustakaan ke dalam bentuk tabel terstruktur di halaman web. Halaman ini menerapkan konsep pembuatan tabel HTML yang terbagi menjadi dua bagian utama

### Penjelasan Perbaris
1. `<nav>`
Baris ini membuka elemen navigasi semantik yang berfungsi sebagai wadah penampung daftar tautan menu halaman.
2. `<ul>`
Baris ini membuka elemen unordered list (daftar tak berurutan) untuk mengelompokkan item menu navigasi.
3. `<li><a href="../index.html">Beranda</a></li>`
Baris ini membuat item daftar berupa tautan menuju halaman utama atau beranda (`index.html`) pada direktori satu tingkat di atasnya.
4. `<li><a href="../buku/list.html">Daftar Buku</a></li>`
Baris ini membuat item daftar berupa tautan menuju halaman daftar buku (`list.html`) di dalam folder `buku`.
5. `<li><a href="list.html">Daftar Anggota</a></li>`
Baris ini membuat item daftar berupa tautan menuju halaman daftar anggota yang sedang aktif saat ini.
6. `<li><a href="tambah.html">Tambah Anggota</a></li>`
Baris ini membuat item daftar berupa tautan menuju form penambahan anggota baru (`tambah.html`).
7. `</ul>`
Baris ini merupakan tag penutup untuk daftar menu navigasi.
8. `</nav>`
Baris ini merupakan tag penutup untuk blok elemen navigasi.
9. `<table>`
Baris ini membuka elemen tabel untuk menampilkan data anggota secara terstruktur dalam baris dan kolom.
10. `<thead>`
Baris ini membuka blok kepala tabel yang mengelompokkan baris judul/nama kolom.
11. `<tr>`
Baris ini mendefinisikan baris pertama di dalam kepala tabel.
12. `<th>No. Anggota</th>`
Baris ini mendefinisikan sel header untuk kolom nomor identitas anggota dengan format teks tebal otomatis.
13. `<th>Nama</th>`
Baris ini mendefinisikan sel header untuk kolom nama lengkap anggota.
14. `<th>Alamat</th>`
Baris ini mendefinisikan sel header untuk kolom domisili atau alamat anggota
15. `<th>No. HP</th>`
Baris ini mendefinisikan sel header untuk kolom nomor telepon anggota.
16. `<th>Aksi</th>`
Baris ini mendefinisikan sel header untuk kolom penyedia tombol operasional data.
17. `</tr>`
Baris ini merupakan tag penutup untuk baris pada kepala tabel.
18. `</thead>`
Baris ini menandai akhir dari blok kepala tabel.
19. `<tbody>`
Baris ini membuka blok badan tabel yang akan menampung seluruh baris data anggota.
20. `<tr>`
Baris ini membuka baris data pertama anggota.
21. `<td>A001</td>`
Baris ini menampilkan sel data nomor anggota untuk baris pertama yaitu "A001".
22. `<td>Siti Aminah</td>`
Baris ini menampilkan sel data nama anggota "Siti Aminah".
23. `<td>Malang</td>`
Baris ini menampilkan sel data alamat anggota yaitu "Malang".
24. `<td>0812xxxx</td>`
Baris ini menampilkan sel data nomor telepon contoh/dummy anggota.
25. `<td>`
Baris ini membuka sel kolom aksi yang menampung tombol-tombol operasi data baris pertama.
26. `<button type="button">Edit</button>`
Baris ini membuat tombol bertipe "button" dengan label "Edit" untuk persiapan aksi pengubahan data.
27. `<button type="button">Hapus</button>`
Baris ini membuat tombol bertipe "button" dengan label "Hapus" untuk persiapan aksi penghapusan data.
28. `</td>`
Baris ini merupakan tag penutup untuk sel kolom aksi pada baris pertama.
29. `</tr>`
Baris ini merupakan tag penutup untuk baris data pertama.
30. `<tr>`
Baris ini membuka baris data kedua anggota.
31. `<td>A002</td>`
Baris ini menampilkan sel data nomor anggota untuk baris kedua yaitu "A002".
32. `<td>Budi Santoso</td>`
Baris ini menampilkan sel data nama anggota "Budi Santoso".
33. `<td>Batu</td>`
Baris ini menampilkan sel data alamat anggota yaitu "Batu".
34. `<td>0813xxxx</td>`
Baris ini menampilkan sel data nomor telepon contoh anggota kedua.
35. `<td>`
Baris ini membuka sel kolom aksi untuk baris kedua.
36. `<button type="button">Edit</button>`
Baris ini membuat tombol "Edit" untuk data anggota kedua.
37. `<button type="button">Hapus</button>`
Baris ini membuat tombol "Hapus" untuk data anggota kedua.
38. `</td>`
Baris ini merupakan tag penutup untuk sel kolom aksi pada baris kedua.
39. `</tr>`
Baris ini merupakan tag penutup untuk baris data kedua.
40. `</tbody>`
Baris ini menandai akhir dari blok badan tabel.
41. `</table>`
Baris ini menandai penutup keseluruhan elemen tabel.

### Kesimpulan
Kode pada file `anggota/list.html` berhasil mengimplementasikan struktur tabel data standar HTML dengan memisahkan area kepala tabel (`<thead>`) dan badan tabel (`<tbody>`) secara semantik. Pola penyusunan baris (`<tr>`), header kolom (`<th>`), sel data (`<td>`), serta penyematan tombol aksi (`<button type="button">`) dan menu navigasi (`<nav>`) menjadikan tampilan daftar anggota terstruktur rapi, konsisten dengan format antarmuka halaman lainnya, dan siap untuk dihubungkan ke fungsionalitas dinamis di tahap berikutnya.

## anggota/tambah.html
Kode di atas merupakan formulir isian HTML (`<form>`) yang digunakan untuk menginputkan data pendaftaran atau penambahan anggota baru. Setiap kolom isian dikelompokkan secara rapi menggunakan elemen paragraf (`<p>`) dengan struktur pasangan label keterangan (`<label>`) dan kotak input data (`<input>`).

Formulir ini juga menerapkan validasi dasar berupa atribut `required` pada field tertentu (Nama dan No. Anggota) yang mewajibkan pengguna mengisinya sebelum dikirim, serta menyediakan field opsional (Alamat dan No. HP). Pada bagian akhir, disediakan sebuah tombol bertipe `submit` untuk memproses pengiriman data form.

### Penjelasan Perbaris
1. `<form>`
Baris ini membuka elemen formulir yang berfungsi sebagai kontainer utama untuk membungkus seluruh input data anggota.
2. `<p>`
Baris ini membuka tag paragraf untuk mengelompokkan area isian nama anggota.
3. `<label for="nama">Nama</label><br>`
Baris ini menampilkan teks label "Nama" yang terhubung ke elemen ber-`id="nama"` melalui atribut `for`, disertai tag `<br>` untuk memindahkan kotak input ke baris berikutnya.
4. `<input type="text" id="nama" name="nama" required>`
Baris ini membuat kotak input teks wajib diisi (`required`) untuk nama anggota dengan identitas `id="nama"` serta nama variabel `name="nama"`.
5. `</p>`
Baris ini merupakan penutup paragraf untuk kelompok isian nama anggota.
6. `<p>`
Baris ini membuka tag paragraf untuk mengelompokkan area isian nomor anggota.
7. `<label for="no_anggota">No. Anggota</label><br>`
Baris ini menampilkan teks label "No. Anggota" yang terhubung ke input ber-`id="no_anggota"`, diikuti line break `<br>`.
8. `<input type="text" id="no_anggota" name="no_anggota" required>`
Baris ini membuat kotak input teks wajib diisi (`required`) untuk nomor identitas anggota dengan `id="no_anggota"` dan `name="no_anggota"`.
9. `</p>`
Baris ini merupakan penutup paragraf untuk kelompok isian nomor anggota.
10. `<p>`
Baris ini membuka tag paragraf untuk mengelompokkan area isian alamat.
11. `<label for="alamat">Alamat</label><br>`
Baris ini menampilkan teks label "Alamat" yang terhubung ke input ber-`id="alamat"`, diikuti tag `<br>`.
12. `<input type="text" id="alamat" name="alamat">`
Baris ini membuat kotak input teks opsional (boleh dikosongkan) untuk data alamat atau domisili anggota.
13. `</p>`
Baris ini merupakan penutup paragraf untuk kelompok isian alamat.
14. `<p>`
Baris ini membuka tag paragraf untuk mengelompokkan area isian nomor handphone.
15. `<label for="no_hp">No. HP</label><br>`
Baris ini menampilkan teks label "No. HP" yang terhubung ke input ber-`id="no_hp"`, diikuti line break `<br>`.
16. `<input type="text" id="no_hp" name="no_hp">`
Baris ini membuat kotak input teks opsional untuk nomor telepon anggota dengan identitas `id="no_hp"` dan parameter pengiriman `name="no_hp"`.
17. `</p>`
Baris ini merupakan penutup paragraf untuk kelompok isian nomor handphone.
18. `<p>`
Baris ini membuka tag paragraf untuk penempatan tombol submit.
19. `<button type="submit">Simpan</button>`
Baris ini membuat tombol bertipe "submit" berlabel "Simpan" yang berfungsi untuk mengeksekusi pengiriman data form saat ditekan.
20. `</p>`
Baris ini merupakan penutup paragraf untuk area tombol simpan.
21. `</form>`
Baris ini menandai penutup keseluruhan blok formulir HTML

### Kesimpulan
Formulir penambahan anggota ini dirancang dengan struktur semantik yang teratur menggunakan pola pengelompokan paragraf (`<p>`) serta keterhubungan aksesibilitas antara atribut `for` pada `<label>` dan `id` pada `<input>`. Penerapan atribut `required` pada field Nama dan No. Anggota memastikan data wajib telah terisi sebelum form disubmit, sementara atribut `name` pada tiap input disiapkan untuk membawa parameter data ke server saat sistem backend diintegrasikan.