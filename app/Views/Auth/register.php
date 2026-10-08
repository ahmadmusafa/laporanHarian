<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= lang('Auth.register') ?> - Aplikasi Laporan Harian</title>

<!-- Bootstrap 5 -->
<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet">

<!-- Bootstrap Icons -->
<link
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    rel="stylesheet">

<style>
    body {
        min-height: 100vh;
        background: #f5f7fb;
    }

    .register-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 30px 15px;
    }

    .register-card {
        width: 100%;
        max-width: 500px;
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
    }

    .register-icon {
        width: 70px;
        height: 70px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        border-radius: 50%;
        background: #e9f2ff;
        color: #0d6efd;
        font-size: 32px;
    }

    .form-control,
    .input-group-text,
    .btn {
        border-radius: 10px;
    }

    .input-group .input-group-text {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        background: #f8f9fa;
    }

    .input-group .form-control {
        border-left: 0;
    }

    .input-group .btn {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }

    .btn-register {
        padding: 12px;
        font-weight: 600;
    }

    .form-label {
        font-weight: 600;
    }
</style>

</head>

<body>

<div class="register-wrapper">

<div class="card register-card">

    <div class="card-body p-4 p-md-5">

        <!-- Header -->
        <div class="text-center mb-4">

            <div class="register-icon">
                <i class="bi bi-person-plus-fill"></i>
            </div>

            <h3 class="fw-bold mb-1">
                <?= lang('Auth.register') ?>
            </h3>

            <p class="text-muted mb-0">
                Buat akun baru untuk melanjutkan
            </p>

        </div>

        <!-- Pesan -->
        <?= view('App\Views\Auth\_message_block') ?>

        <!-- Form -->
        <form action="<?= url_to('register') ?>" method="post">

            <?= csrf_field() ?>

            <!-- Email -->
            <div class="mb-3">

                <label for="email" class="form-label">
                    <?= lang('Auth.email') ?>
                </label>

                <div class="input-group">

                    <span class="input-group-text">
                        <i class="bi bi-envelope"></i>
                    </span>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>"
                        placeholder="<?= lang('Auth.email') ?>"
                        value="<?= old('email') ?>"
                        autocomplete="email">

                </div>

                <small class="text-muted">
                    <?= lang('Auth.weNeverShare') ?>
                </small>

                <?php if (session('errors.email')) : ?>

                    <div class="text-danger small mt-1">
                        <?= session('errors.email') ?>
                    </div>

                <?php endif; ?>

            </div>

            <!-- Username -->
            <div class="mb-3">

                <label for="username" class="form-label">
                    <?= lang('Auth.username') ?>
                </label>

                <div class="input-group">

                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>

                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="form-control <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>"
                        placeholder="<?= lang('Auth.username') ?>"
                        value="<?= old('username') ?>"
                        autocomplete="username">

                </div>

                <?php if (session('errors.username')) : ?>

                    <div class="text-danger small mt-1">
                        <?= session('errors.username') ?>
                    </div>

                <?php endif; ?>

            </div>

            <!-- Password -->
            <div class="mb-3">

                <label for="password" class="form-label">
                    <?= lang('Auth.password') ?>
                </label>

                <div class="input-group">

                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>"
                        placeholder="<?= lang('Auth.password') ?>"
                        autocomplete="new-password">

                    <button
                        type="button"
                        class="btn btn-light border"
                        onclick="togglePassword('password', 'passwordIcon')">

                        <i class="bi bi-eye" id="passwordIcon"></i>

                    </button>

                </div>

                <?php if (session('errors.password')) : ?>

                    <div class="text-danger small mt-1">
                        <?= session('errors.password') ?>
                    </div>

                <?php endif; ?>

            </div>

            <!-- Confirm Password -->
            <div class="mb-4">

                <label for="pass_confirm" class="form-label">
                    <?= lang('Auth.repeatPassword') ?>
                </label>

                <div class="input-group">

                    <span class="input-group-text">
                        <i class="bi bi-shield-lock"></i>
                    </span>

                    <input
                        type="password"
                        id="pass_confirm"
                        name="pass_confirm"
                        class="form-control <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>"
                        placeholder="<?= lang('Auth.repeatPassword') ?>"
                        autocomplete="new-password">

                    <button
                        type="button"
                        class="btn btn-light border"
                        onclick="togglePassword('pass_confirm', 'confirmIcon')">

                        <i class="bi bi-eye" id="confirmIcon"></i>

                    </button>

                </div>

                <?php if (session('errors.pass_confirm')) : ?>

                    <div class="text-danger small mt-1">
                        <?= session('errors.pass_confirm') ?>
                    </div>

                <?php endif; ?>

            </div>

            <!-- Button -->
            <div class="d-grid">

                <button
                    type="submit"
                    class="btn btn-primary btn-register">

                    <i class="bi bi-person-plus me-2"></i>

                    <?= lang('Auth.register') ?>

                </button>

            </div>

        </form>

        <hr class="my-4">

        <!-- Login -->
        <div class="text-center">

            <p class="text-muted mb-0">

                <?= lang('Auth.alreadyRegistered') ?>

                <a
                    href="<?= url_to('login') ?>"
                    class="text-decoration-none fw-semibold">

                    <?= lang('Auth.signIn') ?>

                </a>

            </p>

        </div>

    </div>

</div>

</div>

<script>
    function togglePassword(inputId, iconId) {

        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === "password") {

            input.type = "text";

            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");

        } else {

            input.type = "password";

            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");

        }
    }
</script>

</body>
</html>
