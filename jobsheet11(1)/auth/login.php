<?php require_once __DIR__ . '/../includes/header.php'; ?>
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
        href="<?= BASE_URL ?>/assets/css/style.css"
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


        <?php if (isset($_GET['error'])): ?>
            <p class="alert-error" style="color:#b91c1c;margin-bottom:12px;">Username atau password salah.</p>
        <?php elseif (isset($_GET['register'])): ?>
            <p style="color:#15803d;margin-bottom:12px;">Pendaftaran berhasil. Silakan login.</p>
        <?php endif; ?>

        <form
            action="<?= BASE_URL ?>/auth/proses_login.php"
            method="POST"
        >
<?= csrf_field() ?>

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

            <a href="<?= BASE_URL ?>/auth/register.php">
                Daftar
            </a>

        </p>

    </div>

</div>

</body>
</html>