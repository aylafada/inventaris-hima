document.addEventListener("DOMContentLoaded", function () {

    // hamburger menu 
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

    // konfirmasi hapus
    function initHapusConfirm() {
        const buttons = document.querySelectorAll(".btn-hapus");

        buttons.forEach(function (button) {
            button.addEventListener("click", function () {
                const yakin = confirm("Apakah anda yakin ingin menghapus data ini?");

                if (yakin) {
                    const row = button.closest("tr");

                    if (row) {
                        row.remove();
                    }
                }
            });
        });
    }

    // filter tabel anggota
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

                const text = cells[1].textContent.toLowerCase();

                if (text.includes(keyword)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    }

    // filter buku
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

    // mengambil data buku dengan fetch dan then
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

                    initHapusConfirm();

                    loading.style.display = "none";
                })
                .catch(function () {

                    loading.style.display = "none";
                    error.textContent = "Gagal memuat data";
                });

        }, 1000);
    }

    // mengambil data anggota dengan async/await
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

            tabel.innerHTML = "";

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

            initHapusConfirm();

            loading.style.display = "none";

        } catch (err) {

            loading.style.display = "none";
            error.textContent = "Gagal memuat data";
        }
    }

    // validasi form 
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

            // validasi tahun buku
            const tahun = document.getElementById("tahun");

            if (tahun) {
                const tahunValue = Number(tahun.value);

                if (
                    tahun.value !== "" &&
                    (tahunValue < 1900 || tahunValue > 2026)
                ) {
                    const oldError =
                        tahun.parentElement.querySelector(".error");

                    if (oldError) {
                        oldError.remove();
                    }

                    const error = document.createElement("span");

                    error.classList.add("error");
                    error.textContent =
                        "Tahun terbit harus antara 1900 dan 2026";

                    tahun.parentElement.appendChild(error);

                    valid = false;
                }
            }

            // validasi stok buku
            const stok = document.getElementById("stok");

            if (stok && stok.value !== "") {
                const stokValue = Number(stok.value);

                if (stokValue < 0) {
                    const oldError =
                        stok.parentElement.querySelector(".error");

                    if (oldError) {
                        oldError.remove();
                    }

                    const error = document.createElement("span");

                    error.classList.add("error");
                    error.textContent = "Stok tidak boleh kurang dari 0.";

                    stok.parentElement.appendChild(error);

                    valid = false;
                }
            }

            if (valid) {
                alert("Data berhasil disimpan.");
            }
        });
    }

    // menjalankan fungsi
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initBukuFilter();
    initValidasiForm();

    loadBuku();
    loadAnggota();

});