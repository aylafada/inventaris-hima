<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Register - Inventaris HIMA</title>

    <link
        rel="stylesheet"
        href="/assets/css/style.css"
    >

</head>

<body>

<div class="auth-container">

    <div class="auth-card">

        <p class="eyebrow">
            Inventaris HIMA
        </p>

        <h1>
            Buat Akun
        </h1>

        <p>
            Daftarkan akun petugas inventaris.
        </p>


        <form
            action="/jobsheet10/auth/proses_register.php"
            method="POST"
        >

            <div class="form-group">

                <label for="nama">
                    Nama
                </label>

                <input
                    type="text"
                    id="nama"
                    name="nama"
                    required
                >

            </div>


            <div class="form-group">

                <label for="username">
                    Username
                </label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    required
                >

            </div>


            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >

            </div>


            <button
                type="submit"
                class="btn-primary"
            >
                Daftar
            </button>

        </form>


        <p class="auth-footer">

            Sudah punya akun?

            <a href="/jobsheet10/auth/login.php">
                Login
            </a>

        </p>

    </div>

</div>

</body>
</html>