# LAPORAN JOBSHEET 2 Desain dan Pemrograman Web

### Nama : Aylafada Syakira
### Kelas : TI - 2D
### NIM : 254107020116

## style.css
Jobsheet 2 berfokus pada implementasi styling dasar menggunakan CSS3 pada seluruh halaman aplikasi SIMPUS-Mini (`index.html`, `buku/list.html`, `buku/tambah.html`, `anggota/list.html`, dan `anggota/tambah.html`) tanpa mengubah struktur hierarki konten HTML. File styling dipusatkan pada satu berkas bersama, yaitu `assets/css/style.css`, dengan tujuan menjaga konsistensi visual dan memudahkan penggunaan kembali (reusability).

Dalam jobsheet ini, diterapkan beberapa konsep utama CSS3:
1. Reset & Box Model: Mengatur `box-sizing: border-box` serta menghapus margin dan padding bawaan peramban agar kalkulasi ukuran elemen presisi.
2. Tata Letak Header & Navigasi (Flexbox): Mengatur posisi judul web di sebelah kiri dan deretan menu navigasi di sebelah kanan secara sejajar menggunakan Flexbox (`display: flex`).
3. Komponen Ringkasan Statistik (CSS Grid): Menyusun kartu ringkasan data di Beranda menjadi tata letak 3 kolom sejajar menggunakan CSS Grid (`display: grid`).
4. Styling Tabel Data: Memberikan penataan garis batas sel, efek belang-belang baris genap (zebra-stripe) menggunakan pseudo-class `:nth-child(even)`, efek hover, serta pembedaan warna tombol aksi (*Edit* dan Hapus).
5. Styling Formulir: Mengatur posisi label di atas kotak isian (`display: block`), memberikan ruang padding yang proporsional pada elemen input, serta memberikan warna aksen utama pada tombol pengiriman formulir (submit).

### Penjelasan Perbaris 
1. `* {`
Baris ini membuka deklarasi CSS universal selector untuk memilih seluruh elemen HTML di dalam dokumen.
2. `    box-sizing: border-box;`
Baris ini mengatur model kotak agar ukuran padding dan border dihitung ke dalam total dimensi elemen.
3. `    margin: 0;`
Baris ini menghapus jarak margin luar bawaan (default) pada seluruh elemen HTML.
4. `    padding: 0;`
Baris ini menghapus jarak padding dalam bawaan (default) pada seluruh elemen HTML.
5. `}`
Baris ini merupakan kurung kurawal penutup untuk blok selector universal.
6. `body {`
Baris ini membuka aturan styling untuk elemen `<body>` (badan dokumen).
7. `    font-family: "Segoe UI", Arial, sans-serif;`
Baris ini menentukan jenis font standar yang diterapkan di seluruh halaman web.
8. `    color: #2b2b2b;`
Baris ini mengatur warna teks dasar menjadi abu-abu gelap untuk keterbacaan yang nyaman.
9. `    background-color: #f5f6f8;`
Baris ini mengatur warna latar belakang halaman web menjadi abu-abu terang.
10. `    line-height: 1.5;`
Baris ini mengatur jarak spasi antar-baris teks sebesar 1,5 kali ukuran font.
11. `}`
Baris ini merupakan kurung kurawal penutup untuk selector `body`.
12. `a {`
Baris ini membuka aturan styling untuk semua elemen tautan link (`<a>`).
13. `    color: #1d5b8a;`
Baris ini mengatur warna teks tautan link menjadi biru.
14. `    text-decoration: none;`
Baris ini menghilangkan garis bawah default pada tautan link.
15. `}`
Baris ini merupakan kurung kurawal penutup untuk selector `a`.
16. `a:hover {`
Baris ini membuka aturan pseudo-class saat pointer mouse berada di atas elemen link.
17. `    text-decoration: underline;`
Baris ini menampilkan garis bawah pada teks tautan saat pointer mouse menyorotnya.
18. `}`
Baris ini merupakan penutup aturan pseudo-class `a:hover`.
19. `header {`
Baris ini membuka aturan styling untuk area `<header>`.
20. `    background-color: #1d5b8a;`
Baris ini memberikan warna latar belakang biru tua pada bilah header.
21. `    color: #fff;`
Baris ini mengatur warna teks di dalam header menjadi putih.
22. `    padding: 1rem 1.5rem;`
Baris ini memberikan ruang padding bagian dalam sebesar 1rem atas-bawah dan 1.5rem kiri-kanan.
23. `    display: flex;`
Baris ini mengaktifkan tata letak Flexbox pada kontainer header.
24. `    align-items: center;`
Baris ini menyejajarkan posisi vertikal seluruh item di dalam header agar berada di tengah.
25. `    justify-content: space-between;`
Baris ini meratakan distribusi item secara horizontal (judul di sisi kiri dan navigasi di sisi kanan).
26. `    flex-wrap: wrap;`
Baris ini memungkinkan elemen navigasi berpindah ke baris baru jika ruang layar tidak mencukupi.
27. `}`
Baris ini merupakan penutup blok selector `header`.
28. `header h1 {`
Baris ini membuka aturan khusus untuk elemen judul/logo `<h1>` di dalam header.
29. `    font-size: 1.4rem;`
Baris ini menentukan ukuran font untuk judul aplikasi SIMPUS-Mini sebesar 1.4rem.
30. `}`
Baris ini merupakan penutup blok selector `header h1`.
31. `header nav ul {`
Baris ini membuka aturan styling untuk daftar menu tak berurutan (`<ul>`) di dalam navigasi header.
32. `    list-style: none;`
Baris ini menghilangkan simbol bulet atau titik default dari daftar menu.
33. `    display: flex;`
Baris ini menerapkan Flexbox agar daftar link menu navigasi tersusun mendatar (horizontal).
34. `    gap: 1.25rem;`
Baris ini mengatur jarak pemisah horizontal antar-item menu sebesar 1.25rem.
35. `}`
Baris ini merupakan penutup blok selector `header nav ul`.
36. `header nav a {`
Baris ini membuka aturan styling khusus teks link menu di dalam navigasi header.
37. `    color: #fff;`
Baris ini mengatur warna teks link navigasi menjadi putih.
38. `    font-weight: 500;`
Baris ini mengatur ketebalan teks link navigasi menjadi medium (semi-bold).
39. `}`
Baris ini merupakan penutup blok selector `header nav a`.
40. `main {`
Baris ini membuka aturan styling untuk kontainer konten utama (`<main>`).
41. `    max-width: 1000px;`
Baris ini membatasi lebar maksimal area konten utama sebesar 1000px.
42. `    margin: 2rem auto;`
Baris ini memberikan jarak luar atas-bawah sebesar 2rem dan memposisikan kontainer di tengah layar secara otomatis.
43. `    padding: 0 1.5rem;`
Baris ini memberikan jarak padding bagian dalam kiri dan kanan sebesar 1.5rem.
44. `}`
Baris ini merupakan penutup blok selector `main`.
45. `section {`
Baris ini membuka aturan styling untuk setiap kotak kartu area `<section>`.
46. `    background-color: #fff;`
Baris ini memberikan warna latar belakang putih pada elemen section.
47. `    border-radius: 8px;`
Baris ini memberikan sudut melengkung sebesar 8px pada kontainer section.
48. `    padding: 1.5rem;`
Baris ini memberikan ruang padding bagian dalam section sebesar 1.5rem.
49. `    margin-bottom: 1.5rem;`
Baris ini memberikan jarak batas bawah sebesar 1.5rem antar-section.
50. `    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);`
Baris ini memberikan efek bayangan halus di sekeliling kotak section.
51. `}`
Baris ini merupakan penutup blok selector `section`.
52. `section h2 {`
Baris ini membuka aturan styling untuk teks judul bagian `<h2>`.
53. `    margin-bottom: 1rem;`
Baris ini memberikan jarak bawah 1rem antara judul section dan konten di bawahnya.
54. `    color: #1d5b8a;`
Baris ini memberikan warna teks biru pada judul section.
55. `}`
Baris ini merupakan penutup blok selector `section h2`.
56. `main section:nth-of-type(2) {`
Baris ini memilih elemen section urutan kedua di dalam main yang memuat area ringkasan statistik.
57. `    display: grid;`
Baris ini mengaktifkan tata letak CSS Grid pada kontainer ringkasan statistik.
58. `    grid-template-columns: repeat(3, 1fr);`
Baris ini membagi ruang grid menjadi 3 kolom yang sama besar secara proporsional.
59. `    gap: 1rem;`
Baris ini mengatur jarak renggang (gap) antar-kartu statistik sebesar 1rem.
60. `}`
Baris ini merupakan penutup blok selector `main section:nth-of-type(2)`.
61. `main section:nth-of-type(2) article {`
Baris ini membuka aturan styling untuk setiap kotak kartu statistik (`<article>`).
62. `    background-color: #eef4fa;`
Baris ini memberikan warna latar belakang biru muda lembut pada kartu statistik.
63. `    border-radius: 8px;`
Baris ini memberikan sudut melengkung sebesar 8px pada setiap kartu statistik.
64. `    padding: 1.25rem;`
Baris ini memberikan ruang padding dalam kartu statistik sebesar 1.25rem.
65. `    text-align: center;`
Baris ini menyetel perataan seluruh teks di dalam kartu statistik menjadi rata tengah.
66. `}`
Baris ini merupakan penutup blok selector kartu ringkasan.
67. `main section:nth-of-type(2) article h3 {`
Baris ini membuka aturan untuk teks label ringkasan `<h3>`.
68. `    font-size: 0.95rem;`
Baris ini mengatur ukuran teks label kartu ringkasan menjadi 0.95rem.
69. `    color: #55677a;`
Baris ini memberi warna abu-abu kebiruan pada label kartu ringkasan.
70. `    margin-bottom: 0.5rem;`
Baris ini memberi jarak batas bawah sebesar 0.5rem terhadap angka statistik.
71. `}`
Baris ini merupakan penutup blok selector label ringkasan.
72. `main section:nth-of-type(2) article p {`
Baris ini membuka aturan untuk teks nilai statistik `<p>`.
73. `    font-size: 1.8rem;`
Baris ini mengatur ukuran teks angka statistik menjadi 1.8rem agar tampak dominan.
74. `    font-weight: 700;`
Baris ini membuat format teks angka statistik menjadi tebal (bold).
75. `    color: #1d5b8a;`
Baris ini memberi warna teks biru pada angka statistik.
76. `}`
Baris ini merupakan penutup blok selector teks nilai statistik.
77. `table {`
Baris ini membuka aturan penataan tabel data.
78. `    width: 100%;`
Baris ini mengatur lebar tabel agar mengisi penuh (100%) ruang kontainernya.
79. `    border-collapse: collapse;`
Baris ini menggabungkan garis batas sel tabel menjadi satu garis tunggal.
80. `}`
Baris ini merupakan penutup blok selector `table`.
81. `th, td {`
Baris ini memilih sel header (`<th>`) dan sel data (`<td>`) tabel secara bersamaan.
82. `    text-align: left;`
Baris ini menyetel perataan teks di dalam sel tabel menjadi rata kiri.
83. `    padding: 0.65rem 0.75rem;`
Baris ini memberikan ruang padding dalam sel sebesar 0.65rem atas-bawah dan 0.75rem kiri-kanan.
84. `    border-bottom: 1px solid #e2e6ea;`
Baris ini membuat garis pemisah horizontal berwarna abu-abu terang di bagian bawah sel.
85. `}`
Baris ini merupakan penutup blok selector `th, td`.
86. `thead {`
Baris ini membuka aturan styling untuk area kepala tabel (`<thead>`).
87. `    background-color: #1d5b8a;`
Baris ini memberi warna latar belakang biru pada baris judul kolom tabel.
88. `    color: #fff;`
Baris ini mengatur warna teks judul kolom menjadi putih.
89. `}`
Baris ini merupakan penutup blok selector `thead`.
90. `tbody tr:nth-child(even) {`
Baris ini memilih baris data bernomor genap di dalam badan tabel (*zebra-striping*).
91. `    background-color: #f7f9fb;`
Baris ini memberi warna latar abu-abu sangat terang pada baris genap tabel.
92. `}`
Baris ini merupakan penutup blok selector baris genap tabel.
93. `tbody tr:hover {`
Baris ini membuka aturan interaktif saat baris tabel disorot oleh pointer mouse.
94. `    background-color: #eef4fa;`
Baris ini mengubah warna latar baris tabel menjadi biru muda saat disorot pointer mouse.
95. `}`
Baris ini merupakan penutup blok selector `tbody tr:hover`.
96. `td button {`
Baris ini membuka aturan styling dasar untuk tombol aksi di dalam sel tabel.
97. `    padding: 0.35rem 0.7rem;`
Baris ini mengatur ukuran ruang dalam (padding) pada tombol aksi.
98. `    margin-right: 0.35rem;`
Baris ini memberi jarak margin kanan sebagai pemisah antar-tombol aksi.
99. `    border: none;`
Baris ini menghapus garis tepi luar bawaan (border) dari tombol.
100. `    border-radius: 4px;`
Baris ini memberikan sudut melengkung 4px pada tombol aksi.
101. `    cursor: pointer;`
Baris ini mengubah bentuk kursor menjadi tangan telunjuk saat berada di atas tombol.
102. `    font-size: 0.85rem;`
Baris ini mengatur ukuran teks tombol aksi sebesar 0.85rem.
103. `}`
Baris ini merupakan penutup blok selector `td button`.
104. `td button:first-of-type {`
Baris ini memilih tombol urutan pertama di kolom aksi (tombol Edit).
105. `    background-color: #f0ad4e;`
Baris ini memberikan warna latar belakang oranye/kuning pada tombol Edit.
106. `    color: #fff;`
Baris ini memberikan warna teks putih pada tombol Edit.
107. `}`
Baris ini merupakan penutup blok selector tombol Edit.
108. `td button:last-of-type {`
Baris ini memilih tombol urutan terakhir di kolom aksi (tombol Hapus).
109. `    background-color: #d9534f;`
Baris ini memberikan warna latar belakang merah pada tombol Hapus.
110. `    color: #fff;`
Baris ini memberikan warna teks putih pada tombol Hapus.
111. `}`
Baris ini merupakan penutup blok selector tombol Hapus.
112. `form p {`
Baris ini membuka aturan penataan pengelompokan baris isian pada formulir.
113. `    margin-bottom: 1rem;`
Baris ini memberikan jarak pemisah bawah sebesar 1rem antar-kelompok isian form.
114. `}`
Baris ini merupakan penutup blok selector `form p`.
115. `form label {`
Baris ini membuka aturan styling untuk elemen label formulir.
116. `    display: block;`
Baris ini mengubah label menjadi elemen bertipe block agar letaknya berada di baris atas kotak input.
117. `    margin-bottom: 0.35rem;`
Baris ini memberikan jarak bawah sebesar 0.35rem antara teks label dan kotak isian.
118. `    font-weight: 600;`
Baris ini mengatur ketebalan teks label menjadi semi-bold.
119. `    color: #444;`
Baris ini memberikan warna teks abu-abu gelap pada label formulir.
120. `}`
Baris ini merupakan penutup blok selector `form label`.
121. `form input,`
Baris ini memilih seluruh elemen kotak isian `<input>` di dalam formulir.
122. `form select {`
Baris ini memilih seluruh elemen menu dropdown `<select>` di dalam formulir.
123. `    width: 100%;`
Baris ini membuat lebar field isian memenuhi lebar ruang kontainernya.
124. `    max-width: 400px;`
Baris ini membatasi lebar maksimal kotak isian agar tidak melebihi 400px.
125. `    padding: 0.55rem 0.7rem;`
Baris ini memberikan ruang padding dalam pada kotak isian formulir.
126. `    border: 1px solid #cdd4da;`
Baris ini memberikan garis tepi tipis berwarna abu-abu pada kotak isian.
127. `    border-radius: 4px;`
Baris ini membuat sudut kotak isian melengkung sebesar 4px.
128. `    font-size: 1rem;`
Baris ini mengatur ukuran teks di dalam field isian sebesar 1rem.
129. `}`
Baris ini merupakan penutup blok selector input dan select.
130. `form button[type="submit"] {`
Baris ini membuka aturan styling khusus untuk tombol pengiriman form (*submit*).
131. `    background-color: #1d5b8a;`
Baris ini memberikan warna latar belakang biru aksen utama pada tombol Simpan.
132. `    color: #fff;`
Baris ini mengatur warna teks tombol Simpan menjadi putih.
133. `    border: none;`
Baris ini menghapus garis tepi luar bawaan pada tombol Simpan.
134. `    padding: 0.6rem 1.5rem;`
Baris ini memberikan ukuran ruang padding dalam pada tombol Simpan.
135. `    border-radius: 4px;`
Baris ini memberikan sudut melengkung sebesar 4px pada tombol Simpan.
136. `    font-size: 1rem;`
Baris ini mengatur ukuran font teks tombol Simpan sebesar 1rem.
137. `    cursor: pointer;`
Baris ini mengubah bentuk kursor menjadi tangan telunjuk saat mengarah ke tombol Simpan.
138. `}`
Baris ini merupakan penutup blok selector tombol submit.
139. `form button[type="submit"]:hover {`
Baris ini membuka aturan pseudo-class saat tombol Simpan disorot pointer mouse.
140. `    background-color: #164869;`
Baris ini mengubah warna tombol Simpan menjadi biru yang lebih gelap saat disorot.
141. `}`
Baris ini merupakan penutup aturan hover tombol submit.
142. `footer {`
Baris ini membuka aturan styling untuk area kaki halaman (`<footer>`).
143. `    text-align: center;`
Baris ini mengatur posisi teks hak cipta pada footer menjadi rata tengah.
144. `    padding: 1.25rem;`
Baris ini memberikan ruang padding dalam sebesar 1.25rem pada footer.
145. `    color: #7a8794;`
Baris ini memberikan warna teks abu-abu lembut pada footer.
146. `    font-size: 0.9rem;`
Baris ini mengatur ukuran teks footer sebesar 0.9rem.
147. `}`
Baris ini menandai penutup keseluruhan aturan berkas CSS.

### Kesimpulan

Penerapan CSS3 melalui berkas `assets/css/style.css` pada Jobsheet 2 berhasil membangun antarmuka web SIMPUS-Mini yang konsisten, terstruktur, dan memiliki keterbacaan yang baik tanpa perlu merombak struktur dasar dokumen HTML. Pemanfaatan modul tata letak modern seperti Flexbox pada header/navigasi dan CSS Grid pada kartu statistik ringkasan memungkinkan penataan posisi elemen yang rapi serta adaptif. Selain itu, teknik pewarnaan belang-belang (zebra-striping) dan efek *hover* pada tabel data serta penataan vertikal elemen formulir menggunakan `display: block` pada label memberikan kejelasan informasi dan kenyamanan visual bagi pengguna.
