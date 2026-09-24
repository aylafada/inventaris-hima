document.addEventListener("DOMContentLoaded", function () {

    // Hamburger menu
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


    // Konfirmasi tombol hapus
    function initHapusConfirm() {
        const buttons = document.querySelectorAll(".btn-hapus");

        buttons.forEach(function (button) {

            button.addEventListener("click", function () {

                const yakin = confirm(
                    "Apakah anda yakin ingin menghapus data ini?"
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


    // Pencarian buku
    function initBukuFilter() {

        const searchInput =
            document.getElementById("search-buku");

        if (!searchInput) {
            return;
        }

        searchInput.addEventListener("keyup", function () {

            const keyword =
                searchInput.value.toLowerCase();

            const rows =
                document.querySelectorAll("#tabel-buku tr");

            rows.forEach(function (row) {

                const cells =
                    row.querySelectorAll("td");

                if (cells.length === 0) {
                    return;
                }

                const judul =
                    cells[0].textContent.toLowerCase();

                if (judul.includes(keyword)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }

            });

        });
    }


    // Pencarian anggota
    function initAnggotaFilter() {

        const searchInput =
            document.getElementById("search-input");

        if (!searchInput) {
            return;
        }

        searchInput.addEventListener("keyup", function () {

            const keyword =
                searchInput.value.toLowerCase();

            const rows =
                document.querySelectorAll("#tabel-anggota tr");

            rows.forEach(function (row) {

                const cells =
                    row.querySelectorAll("td");

                if (cells.length === 0) {
                    return;
                }

                const nama =
                    cells[1].textContent.toLowerCase();

                if (nama.includes(keyword)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }

            });

        });
    }


    // Validasi tambahan di browser
    // Form tetap dikirim ke PHP jika valid.
    function initValidasiForm() {

        const form =
            document.getElementById("form-tambah");

        if (!form) {
            return;
        }

        form.addEventListener("submit", function (event) {

            const inputs =
                form.querySelectorAll("input");

            let valid = true;

            inputs.forEach(function (input) {

                const oldError =
                    input.parentElement.querySelector(".error");

                if (oldError) {
                    oldError.remove();
                }

                if (input.value.trim() === "") {

                    const error =
                        document.createElement("span");

                    error.classList.add("error");

                    error.textContent =
                        input.previousElementSibling.textContent +
                        " wajib diisi.";

                    input.parentElement.appendChild(error);

                    valid = false;
                }

            });


            // Validasi tahun buku
            const tahun =
                document.getElementById("tahun");

            if (tahun && tahun.value !== "") {

                const tahunValue =
                    Number(tahun.value);

                if (
                    tahunValue < 1900 ||
                    tahunValue > 2026
                ) {

                    const oldError =
                        tahun.parentElement.querySelector(".error");

                    if (oldError) {
                        oldError.remove();
                    }

                    const error =
                        document.createElement("span");

                    error.classList.add("error");

                    error.textContent =
                        "Tahun terbit harus antara 1900 dan 2026.";

                    tahun.parentElement.appendChild(error);

                    valid = false;
                }
            }


            // Validasi stok
            const stok =
                document.getElementById("stok");

            if (stok && stok.value !== "") {

                const stokValue =
                    Number(stok.value);

                if (stokValue < 0) {

                    const oldError =
                        stok.parentElement.querySelector(".error");

                    if (oldError) {
                        oldError.remove();
                    }

                    const error =
                        document.createElement("span");

                    error.classList.add("error");

                    error.textContent =
                        "Stok tidak boleh kurang dari 0.";

                    stok.parentElement.appendChild(error);

                    valid = false;
                }
            }


            // Hanya hentikan submit jika validasi client gagal.
            if (!valid) {
                event.preventDefault();
            }

        });
    }


    initNavToggle();
    initHapusConfirm();
    initBukuFilter();
    initAnggotaFilter();
    initValidasiForm();

});