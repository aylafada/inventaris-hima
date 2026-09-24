# LAPORAN JOBSHEET 5 DPW

### Nama : Aylafada Syakira
### Kelas : TI - 2D
### NIM : 254107020116

### 1. Tambah `assets/js/app.js`

```javascript
document.addEventListener("DOMContentLoaded", function () {
```

Kode tersebut digunakan untuk memastikan seluruh elemen HTML sudah selesai dibuat sebelum JavaScript dijalankan.

---

### 2. Hamburger menu: checkbox hack (CSS) diganti tombol + JS (`nav.classList.toggle("nav-open")`)

```javascript
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");

    if (!toggleBtn || !nav) {
        return;
    }

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}
```

Fungsi ini mengatur tombol hamburger. Ketika tombol diklik, class `nav-open` akan ditambahkan atau dihapus pada menu navigasi sehingga menu dapat dibuka dan ditutup menggunakan JavaScript.

---

### 3. Form Tambah Buku & Tambah Anggota: validasi client-side (`initValidasiForm`) — field wajib, rentang tahun, stok non-negatif — pesan error tampil inline via manipulasi DOM

```javascript
function initValidasiForm() {
    const form = document.getElementById("form-tambah");

    if (!form) {
        return;
    }

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        const inputs = form.querySelectorAll("input");
        let valid = true;

        inputs.forEach(function (input) {
            const oldError = input.parentElement.querySelector(".error");

            if (oldError) {
                oldError.remove();
            }

            if (input.value.trim() === "") {
                const error = document.createElement("span");

                error.classList.add("error");
                error.textContent =
                    input.previousElementSibling.textContent +
                    " wajib diisi.";

                input.parentElement.appendChild(error);

                valid = false;
            }
        });
```

Kode memeriksa setiap input pada form. Jika terdapat field yang kosong, JavaScript membuat elemen `<span class="error">` dan menampilkan pesan kesalahan langsung di bawah input tanpa melakukan reload halaman.

---

### 4. Tabel Daftar Buku & Daftar Anggota: kolom pencarian real-time (`initTableFilter`) yang menyaring baris via `keyup`

```javascript
function initTableFilter() {
    const searchInput = document.getElementById("search-input");

    if (!searchInput) {
        return;
    }

    searchInput.addEventListener("keyup", function () {
        const keyword = searchInput.value.toLowerCase();
        const rows = document.querySelectorAll("table tbody tr");

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

Kode membaca teks yang diketik pada kolom pencarian setiap kali tombol keyboard dilepas (`keyup`). Baris tabel kemudian ditampilkan atau disembunyikan berdasarkan kecocokan kata pencarian.

---

### 5. Tombol Hapus (`.btn-hapus`): menampilkan `confirm()` lalu menghapus baris dari tampilan

```javascript
function initHapusConfirm() {
    const buttons = document.querySelectorAll(".btn-hapus");

    buttons.forEach(function (button) {
        button.addEventListener("click", function () {
            const yakin = confirm(
                "Apakah Anda yakin ingin menghapus data ini?"
            );

            if (yakin) {
                const row = button.closest("tr");

                if (row) {
                    row.remove();
                }
            }
        });
    });
}
```

Saat tombol Hapus diklik, JavaScript menampilkan kotak konfirmasi. Jika pengguna memilih OK, baris data pada tabel dihapus dari tampilan. Penghapusan ini masih hanya pada sisi frontend dan belum tersimpan ke server atau database.

---

## Kesimpulan

Pada Jobsheet 5 dilakukan penambahan JavaScript pada website SIMPUS-Mini untuk meningkatkan interaksi pada halaman web. Fitur yang dibuat meliputi hamburger menu, validasi form secara client-side, pencarian data pada tabel secara real-time, serta tombol hapus dengan konfirmasi.

Seluruh fitur tersebut berjalan pada sisi frontend menggunakan JavaScript dan manipulasi DOM, sehingga pengguna dapat berinteraksi dengan halaman tanpa perlu melakukan reload untuk setiap aksi.
