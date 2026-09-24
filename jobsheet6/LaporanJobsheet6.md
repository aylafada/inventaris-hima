# LAPORAN JOBSHEET 6 Desain dan Pemrograman Web

### Nama : Aylafada Syakira
### Kelas : TI - 2D
### NIM : 254107020116


### 1. Membuat file `data/buku.json` yang berisi data buku dalam format JSON.

```json
[
    {
        "judul": "Laskar Pelangi",
        "pengarang": "Andrea Hirata",
        "tahun": 2005,
        "stok": 4
    },
    {
        "judul": "Bumi Manusia",
        "pengarang": "Pramoedya Ananta Toer",
        "tahun": 1980,
        "stok": 2
    },
    {
        "judul": "Negeri 5 Menara",
        "pengarang": "Ahmad Fuadi",
        "tahun": 2009,
        "stok": 0
    }
]
```

Kode tersebut merupakan contoh struktur data buku dalam format JSON. Setiap objek menyimpan informasi judul, pengarang, tahun terbit, dan stok buku. Data buku yang sebelumnya ditulis langsung pada HTML dipindahkan ke file JSON agar dapat diambil secara dinamis menggunakan `fetch()`.

### 2. Mengosongkan `<tbody>` pada tabel Daftar Buku dan menambahkan `id` untuk menampilkan data secara dinamis.

```html
<tbody id="tabel-buku">
</tbody>
```

Kode tersebut membuat bagian `<tbody>` tabel tidak lagi berisi data buku secara langsung. `id="tabel-buku"` digunakan sebagai penanda agar JavaScript dapat menemukan bagian tabel tersebut dan memasukkan data yang diperoleh dari file `buku.json`.

### 3. Menambahkan loading indicator pada halaman Daftar Buku.

```html
<div id="loading-buku" class="loading">
    Memuat data...
</div>
```

Kode tersebut digunakan untuk menampilkan tulisan "Memuat data..." ketika proses pengambilan data sedang berlangsung. Loading indicator memberikan informasi kepada pengguna bahwa data sedang diproses.

### 4. Menambahkan tempat untuk menampilkan pesan error pada halaman Daftar Buku.

```html
<div id="error-buku" class="error"></div>
```

Kode tersebut digunakan sebagai tempat untuk menampilkan pesan kesalahan apabila proses pengambilan data dari file JSON gagal. Pesan error akan diisi melalui JavaScript.

### 5. Mengambil data buku menggunakan `fetch()`.

```javascript
function loadBuku() {
    const loading = document.getElementById("loading-buku");
    const error = document.getElementById("error-buku");
    const tabel = document.getElementById("tabel-buku");

    if (!tabel) {
        return;
    }

    loading.style.display = "block";
    error.textContent = "";

    setTimeout(function () {

        fetch("../data/buku.json")
            .then(function (response) {

                if (!response.ok) {
                    throw new Error("Gagal mengambil data");
                }

                return response.json();
            })
```

Fungsi `loadBuku()` digunakan untuk mengambil data buku dari file `buku.json`. `document.getElementById()` digunakan untuk mengambil elemen loading, pesan error, dan tabel. `fetch("../data/buku.json")` digunakan untuk meminta data dari file JSON. Setelah data berhasil diterima, `response.json()` mengubah data tersebut menjadi objek JavaScript agar dapat diproses.

### 6. Menambahkan `setTimeout()` untuk mensimulasikan delay jaringan.

```javascript
setTimeout(function () {

    fetch("../data/buku.json")

}, 1000);
```

Kode tersebut memberikan jeda selama 1000 milidetik atau 1 detik sebelum proses `fetch()` dijalankan. Jeda ini digunakan untuk mensimulasikan keterlambatan jaringan sehingga loading indicator dapat terlihat pada halaman.

### 7. Menampilkan data buku ke dalam tabel menggunakan perulangan.

```javascript
.then(function (data) {

    tabel.innerHTML = "";

    data.forEach(function (buku) {

        const row = document.createElement("tr");

        row.innerHTML = `
            <td>${buku.judul}</td>
            <td>${buku.pengarang}</td>
            <td>${buku.stok}</td>
            <td>${buku.tahun}</td>
            <td>
                <button type="button">Edit</button>
                <button type="button">Detail</button>
                <button type="button" class="btn-hapus">Hapus</button>
            </td>
        `;

        tabel.appendChild(row);
    });
```

Kode tersebut melakukan perulangan terhadap seluruh data buku yang diperoleh dari JSON menggunakan `forEach()`. Setiap data buku dibuat menjadi elemen `<tr>` menggunakan `document.createElement()`. Data judul, pengarang, stok, dan tahun dimasukkan ke dalam tabel menggunakan template literal. `appendChild()` kemudian menambahkan baris tersebut ke dalam `<tbody>`.

### 8. Menghilangkan loading setelah data berhasil ditampilkan.

```javascript
initHapusConfirm();

loading.style.display = "none";
```

Kode tersebut menjalankan kembali fungsi konfirmasi hapus agar tombol Hapus pada baris yang baru dibuat tetap dapat digunakan. Setelah data berhasil ditampilkan, `loading.style.display = "none"` digunakan untuk menyembunyikan loading indicator.

### 9. Menangani kesalahan menggunakan `catch()`.

```javascript
.catch(function () {

    loading.style.display = "none";
    error.textContent = "Gagal memuat data";
});
```

Kode tersebut digunakan untuk menangani kesalahan ketika proses `fetch()` gagal. Loading indicator disembunyikan dan pesan `"Gagal memuat data"` ditampilkan pada halaman. Pengujian dapat dilakukan dengan mengubah nama file JSON menjadi nama yang salah.

### 10. Membuat file `data/anggota.json` untuk menyimpan data anggota.

```json
[
    {
        "no_anggota": "A001",
        "nama": "Siti Aminah",
        "alamat": "Malang",
        "no_hp": "081234567"
    },
    {
        "no_anggota": "A002",
        "nama": "Budi Santoso",
        "alamat": "Batu",
        "no_hp": "081334567"
    }
]
```

Kode tersebut merupakan struktur data anggota dalam format JSON. Setiap objek menyimpan nomor anggota, nama, alamat, dan nomor HP. Data ini digunakan sebagai sumber data untuk halaman Daftar Anggota.

### 11. Mengosongkan `<tbody>` pada tabel Daftar Anggota.

```html
<tbody id="tabel-anggota">
</tbody>
```

Kode tersebut digunakan agar data anggota tidak lagi ditulis secara langsung pada HTML. `id="tabel-anggota"` digunakan oleh JavaScript untuk menentukan lokasi tabel yang akan diisi dengan data dari `anggota.json`.

### 12. Menambahkan loading indicator dan pesan error pada Daftar Anggota.

```html
<div id="loading-anggota" class="loading">
    Memuat data...
</div>

<div id="error-anggota" class="error"></div>
```

Kode tersebut digunakan untuk memberikan indikator bahwa data anggota sedang dimuat dan menyediakan tempat untuk menampilkan pesan kesalahan apabila proses pengambilan data gagal.

### 13. Mengambil data anggota menggunakan `async/await`.

```javascript
async function loadAnggota() {
    const loading = document.getElementById("loading-anggota");
    const error = document.getElementById("error-anggota");
    const tabel = document.getElementById("tabel-anggota");

    if (!tabel) {
        return;
    }

    loading.style.display = "block";
    error.textContent = "";

    try {
        await new Promise(function (resolve) {
            setTimeout(resolve, 1000);
        });

        const response = await fetch("../data/anggota.json");

        if (!response.ok) {
            throw new Error("Gagal mengambil data");
        }

        const data = await response.json();
```

Fungsi `loadAnggota()` menggunakan pola `async/await` sebagai alternatif dari `.then()`. Kata kunci `async` digunakan untuk membuat fungsi asynchronous, sedangkan `await` digunakan untuk menunggu proses selesai sebelum melanjutkan ke proses berikutnya. Data anggota diambil dari `anggota.json` menggunakan `fetch()`.

### 14. Menampilkan data anggota secara dinamis menggunakan `forEach()`.

```javascript
data.forEach(function (anggota) {

    const row = document.createElement("tr");

    row.innerHTML = `
        <td>${anggota.no_anggota}</td>
        <td>${anggota.nama}</td>
        <td>${anggota.alamat}</td>
        <td>${anggota.no_hp}</td>
        <td>
            <button type="button">Edit</button>
            <button type="button" class="btn-hapus">Hapus</button>
        </td>
    `;

    tabel.appendChild(row);
});
```

Kode tersebut melakukan perulangan terhadap data anggota yang berasal dari JSON. Setiap anggota dibuat menjadi satu baris tabel dengan elemen `<tr>`. Informasi nomor anggota, nama, alamat, dan nomor HP dimasukkan ke dalam tabel secara dinamis.

### 15. Menangani error pada proses pengambilan data anggota.

```javascript
} catch (err) {

    loading.style.display = "none";
    error.textContent = "Gagal memuat data";
}
```

Kode tersebut menggunakan `try...catch` untuk menangani kesalahan pada proses `async/await`. Jika terjadi kesalahan, loading indicator disembunyikan dan pesan `"Gagal memuat data"` ditampilkan kepada pengguna.

### 16. Menambahkan fungsi pencarian untuk Daftar Buku.

```javascript
function initBukuFilter() {
    const searchInput = document.getElementById("search-buku");

    if (!searchInput) {
        return;
    }

    searchInput.addEventListener("keyup", function () {
        const keyword = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll("#tabel-buku tr");

        rows.forEach(function (row) {
            const cells = row.querySelectorAll("td");

            if (cells.length === 0) {
                return;
            }

            const text = cells[0].textContent.toLowerCase();

            if (text.includes(keyword)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
}
```

Fungsi tersebut digunakan untuk melakukan pencarian buku berdasarkan judul secara langsung ketika pengguna mengetik pada kolom pencarian. JavaScript membaca nilai input kemudian membandingkannya dengan isi kolom judul pada setiap baris tabel. Baris yang sesuai akan ditampilkan, sedangkan baris yang tidak sesuai akan disembunyikan.

### 17. Memperbaiki pencarian Daftar Anggota agar berdasarkan nama.

```javascript
const text = cells[1].textContent.toLowerCase();
```

Kode tersebut mengambil isi kolom kedua pada tabel anggota, yaitu kolom Nama. Sebelumnya indeks yang digunakan adalah `cells[0]` yang merupakan nomor anggota. Dengan menggunakan `cells[1]`, pencarian dapat dilakukan berdasarkan nama anggota sesuai dengan label pencarian.

### 18. Menambahkan fungsi loading ke dalam CSS.

```css
.loading {
    padding: 1rem;
    margin-bottom: 1rem;
    text-align: center;
    color: #11340a;
    font-weight: 600;
}
```

Kode CSS tersebut digunakan untuk mengatur tampilan loading indicator agar memiliki jarak, posisi teks di tengah, dan tulisan yang lebih mudah dilihat oleh pengguna.

### 19. Menjalankan fungsi Jobsheet 6 ketika halaman selesai dimuat.

```javascript
initNavToggle();
initHapusConfirm();
initTableFilter();
initBukuFilter();
initValidasiForm();

loadBuku();
loadAnggota();
```

Kode tersebut digunakan untuk menjalankan seluruh fungsi JavaScript yang telah dibuat. `loadBuku()` digunakan untuk mengambil data buku dari JSON, sedangkan `loadAnggota()` digunakan untuk mengambil data anggota dari JSON. Fungsi dari jobsheet sebelumnya seperti navigasi, pencarian, validasi form, dan konfirmasi hapus tetap dijalankan.

### 20. Mengubah keterangan footer menjadi Jobsheet 6.

```html
<footer>
    <p>&copy; 2026 SIMPUS-Mini &mdash; Jobsheet 6</p>
</footer>
```

Kode tersebut digunakan untuk mengubah keterangan footer dari Jobsheet 5 menjadi Jobsheet 6 sebagai penanda bahwa project telah diperbarui untuk materi Jobsheet 6.

## Kesimpulan

Pada Jobsheet 6 telah diterapkan komunikasi asinkron menggunakan `fetch()` dan JSON. Data buku dan anggota yang sebelumnya ditulis secara langsung pada HTML dipindahkan ke file JSON dan ditampilkan secara dinamis menggunakan JavaScript. Selain itu, telah diterapkan loading indicator menggunakan `setTimeout()` untuk mensimulasikan delay jaringan serta penanganan error menggunakan `catch()` dan `try...catch`. Pola `async/await` juga diterapkan pada proses pengambilan data anggota sebagai alternatif dari penggunaan `.then()`. Dengan penerapan tersebut, halaman Daftar Buku dan Daftar Anggota dapat mengambil dan menampilkan data secara asinkron tanpa melakukan hardcode data pada HTML.
