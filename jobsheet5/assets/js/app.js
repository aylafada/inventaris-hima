document.addEventListener("DOMContentLoaded", function () {

    //hamburger menu 
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

    //konfirm hapus
    function initHapusConfirm() {
        const buttons = document.querySelectorAll(".btn-hapus");

        buttons.forEach(function (button) {
            button.addEventListener("click", function () {
                const yakin = confirm ("Apakah anda yakin ingin menghapus data ini? ");

                if (yakin) {
                    const row = button.closest("tr");
                    if (row) {
                        row.remove();
                    }
                }

            });

        });
    }

    //filter table
    function initTableFilter() {
        const searchInput = document.getElementById("search-input");
        if (!searchInput) {
            return;
        }

        searchInput.addEventListener("keyup", function () {
            const keyword = searchInput.value.toLowerCase();
            const row = document.querySelectorAll("table tbody tr");

            row.forEach(function (row) {
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

    //validasi form 
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
                    error.textContent = input.previousElementSibling.textContent + " wajib diisi.";

                    input.parentElement.appendChild(error);

                    valid = false;
                }
            });

            //validasi tahun buku
            const tahun = document.getElementById("tahun");

            if (tahun) {
                const tahunValue = Number(tahun.value);

                if (tahun.value !== "" && (tahunValue < 1900 || tahunValue > 2026)) {
                    const oldError = tahun.parentElement.querySelector(".error");

                    if (oldError) {
                        oldError.remove();
                    }

                    const error = document.createElement("span");

                    error.classList.add("error");
                    error.textContent = "Tahun terbit harus antara 1900 dan 2026";

                    tahun.parentElement.appendChild(error);

                    valid = false;
                }

            }

            //validasi stok buku
            const stok = document.getElementById("stok");

            if (stok && stok.value !=="") {
                const stokValue = Number(stok.value);

                if (stokValue < 0) {
                    const oldError = stok.parentElement.querySelector(".error");

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

    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initValidasiForm();
});