document.addEventListener("DOMContentLoaded", function () {

    const deleteButtons = document.querySelectorAll(".danger");

    deleteButtons.forEach(function (button) {

        button.addEventListener("click", function (event) {

            const confirmed = confirm(
                "Yakin ingin menghapus data ini?"
            );

            if (!confirmed) {
                event.preventDefault();
            }

        });

    });

});