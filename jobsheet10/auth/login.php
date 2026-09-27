<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login - Inventaris HIMA</title>

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
            Login
        </h1>

        <p>
            Masuk untuk mengelola inventaris HIMA.
        </p>


        <form
            action="/auth/proses_login.php"
            method="POST"
        >

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
                Login
            </button>

        </form>


        <p class="auth-footer">

            Belum punya akun?

            <a href="/auth/register.php">
                Daftar
            </a>

        </p>

    </div>

</div>

</body>
</html>