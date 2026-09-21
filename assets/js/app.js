document.addEventListener("DOMContentLoaded", function () {
    // 1. Tangani konfirmasi hapus tanpa dobel popup
    const deleteButtons = document.querySelectorAll(".btn-small.danger");

    deleteButtons.forEach(function (button) {
        // Jika sudah ada inline onclick di HTML, jangan tumpuk listener confirm lagi
        if (!button.hasAttribute("onclick")) {
            button.addEventListener("click", function (event) {
                const confirmed = confirm("Yakin ingin menghapus data ini?");
                if (!confirmed) {
                    event.preventDefault();
                }
            });
        }
    });

    // 2. Cegah double click / multiple submit pada form
    const forms = document.querySelectorAll("form");
    forms.forEach(function (form) {
        form.addEventListener("submit", function () {
            const submitBtn = form.querySelector("button[type='submit']");
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerText = "Menyimpan...";
            }
        });
    });

    // 3. Auto-focus ke input pertama di form (jika ada)
    const firstInput = document.querySelector(".form-card input:not([type='hidden']), .form-card select");
    if (firstInput) {
        firstInput.focus();
    }
});