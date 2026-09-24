# LAPORAN JOBSHEET 3 Desain dan Pemrograman Web

### Nama : Aylafada Syakira
### Kelas : TI - 2D
### NIM : 254107020116

## Penambahan Meta Viewport
Menambahkan baris konfigurasi viewport pada seluruh tag `<head>` dokumen HTML (index.html, halaman buku, dan halaman anggota)
`<meta name="viewport" content="width=device-width, initial-scale=1.0">`
Tujuan: Menginstruksikan browser agar menyesuaikan lebar halaman sesuai lebar layar fisik perangkat tanpa pengecilan skala (desktop zooming).

## Penyesuaian Navbar Responsif
Pada layar berukuran <768px, navigasi diatur agar bertumpuk vertikal secara rapi
`@media (max-width: 768px) {`
    `header {`
        `flex-direction: column;`
        `align-items: flex-start;`
        `gap: 0.75rem;`
    `}`
    `header nav ul {`
        `flex-direction: column;`
        `width: 100%;`
        `gap: 0.5rem;`
    `}`
    `header nav ul li a {`
        `display: block;`
        `padding: 0.35rem 0;`
    `}`
`}`

## Tabel Daftar Buku (Horizontak Scroll Wrapper)
Membungkus tabel daftar buku menggunakan kontainer div.table-container agar tidak meluap ke luar layar saat dibuka di layar sempit
`<div class="table-container">`
    `<table>`
        `<!-- Data Tabel Buku -->`
   `</table>`
`</div>`

## Grid Kartu Statistik Beranda
Mengubah layout kartu ringkasan di index.html dari 3 kolom (desktop) menjadi 1 kolom (mobile/tablet)
`@media (max-width: 768px) {`
   ` main section:nth-of-type(2) {`
      `  grid-template-columns: 1fr;`
   ` }`
`}`

## Penerapan 3 BreakPoint CSS
Penerapan 3 Breakpoint CSSSeluruh file CSS diselaraskan menggunakan 3 tingkatan breakpoint terpadu:
1. Desktop >1024: Area main maksimal 1100px, padding lega, dan grid 3 kolom berdampinga
2. Tablet <768: Navbar vertikal, grid 1 kolom, dan kolom form adaptif
3. Mobile <480: Margin kontainer lebih rapat, tombol aksi tabel tersusun penuh (stacked), serta tombol submit selebar layar.

Pola responsif yang sama diterapkan pada modul Data Anggota:
1. Halaman Daftar Anggota (anggota/list.html): 
- Ditambahkan meta viewport di bagian `<head>`.
- Elemen `<table>` dibungkus menggunakan `<div class="table-container">` agar kolom data anggota (No. Anggota, Nama, Alamat, No. HP, Aksi) dapat digeser menyamping tanpa merusak tata letak keseluruhan.
- Tombol aksi (Edit dan Hapus) otomatis menyesuaikan ukuran layar ponsel.

Halaman Tambah Anggota (anggota/tambah.html)
- :Struktur formulir distandarisasi menggunakan class `.form-group` dan `.form-actions.`
- Pada breakpoint tablet dan mobile, input teks (`input[type="text"]`, dll.) serta tombol simpan otomatis melebar $100\%$ agar nyaman ditekan pada layar sentuh.

## Kesimpulan
Melalui penambahan meta viewport, wrapper scroll horizontal pada tabel, serta penerapan media queries pada 3 breakpoint standar, seluruh halaman SIMPUS-Mini (baik halaman utama, modul Buku, maupun modul Anggota) telah berhasil responsif tanpa ada elemen yang terpotong atau merusak layout di layar perangkat mobile.
