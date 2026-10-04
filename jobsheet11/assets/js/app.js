document.addEventListener("DOMContentLoaded", function () {

    /*
    |--------------------------------------------------------------------------
    | Cegah double submit
    |--------------------------------------------------------------------------
    */

    const forms = document.querySelectorAll("form");

    forms.forEach(function (form) {

        form.addEventListener("submit", function (event) {

            const submitBtn = form.querySelector(
                "button[type='submit']"
            );

            if (submitBtn) {

                if (submitBtn.disabled) {
                    event.preventDefault();
                    return;
                }

                submitBtn.disabled = true;

                if (submitBtn.classList.contains("danger")) {
                    submitBtn.innerText = "Menghapus...";
                } else {
                    submitBtn.innerText = "Menyimpan...";
                }
            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Auto-focus input pertama pada form
    |--------------------------------------------------------------------------
    */

    const firstInput = document.querySelector(
        ".form-card input:not([type='hidden']), .form-card select"
    );

    if (firstInput) {
        firstInput.focus();
    }

});