<?php /** @var \Myth\Auth\Config\Auth $config */ ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= lang('Auth.loginTitle') ?> - Laporan Harian</title>

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">
</head>

<body class="bg-body">

    <div class="container min-vh-100 d-flex align-items-center justify-content-center">

        <div class="card shadow-sm border-0 w-100" style="max-width: 420px;">

            <div class="card-body p-4">

                <!-- LOGO -->
                <div class="text-center mb-3">

                    <img
                        src="<?= base_url('assets/img/logo_sinsen_together_as_one.svg') ?>"
                        alt="Sinsen Together As One"
                        class="img-fluid"
                        style="max-height: 70px;">

                </div>

                <!-- PESAN ERROR / SUCCESS -->
                <?= view('App\Views\Auth\_message_block') ?>

                <!-- FORM LOGIN -->
                <form action="<?= url_to('login') ?>" method="post">

                    <?= csrf_field() ?>

                    <!-- EMAIL / USERNAME -->
                    <?php if ($config->validFields === ['email']): ?>

                        <div class="mb-3">

                            <label for="login" class="form-label">
                                <?= lang('Auth.email') ?>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-envelope"></i>
                                </span>

                                <input
                                    type="email"
                                    id="login"
                                    name="login"
                                    class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                                    placeholder="<?= lang('Auth.email') ?>"
                                    value="<?= old('login') ?>"
                                    autocomplete="email">

                            </div>

                            <?php if (session('errors.login')) : ?>

                                <div class="text-danger small mt-1">
                                    <?= session('errors.login') ?>
                                </div>

                            <?php endif; ?>

                        </div>

                    <?php else: ?>

                        <div class="mb-3">

                            <label for="login" class="form-label">
                                <?= lang('Auth.emailOrUsername') ?>
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-person"></i>
                                </span>

                                <input
                                    type="text"
                                    id="login"
                                    name="login"
                                    class="form-control <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>"
                                    placeholder="<?= lang('Auth.emailOrUsername') ?>"
                                    value="<?= old('login') ?>"
                                    autocomplete="username">

                            </div>

                            <?php if (session('errors.login')) : ?>

                                <div class="text-danger small mt-1">
                                    <?= session('errors.login') ?>
                                </div>

                            <?php endif; ?>

                        </div>

                    <?php endif; ?>

                    <!-- PASSWORD -->
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
                                autocomplete="current-password">

                            <button
                                type="button"
                                class="btn btn-outline-secondary"
                                onclick="togglePassword()">

                                <i class="bi bi-eye" id="passwordIcon"></i>

                            </button>

                        </div>

                        <?php if (session('errors.password')) : ?>

                            <div class="text-danger small mt-1">
                                <?= session('errors.password') ?>
                            </div>

                        <?php endif; ?>

                    </div>

                    <!-- REMEMBER ME -->
                    <?php if ($config->allowRemembering): ?>

                        <div class="form-check mb-3">

                            <input
                                type="checkbox"
                                name="remember"
                                id="remember"
                                class="form-check-input"
                                <?php if (old('remember')) : ?>checked<?php endif ?>>

                            <label
                                for="remember"
                                class="form-check-label">

                                <?= lang('Auth.rememberMe') ?>

                            </label>

                        </div>

                    <?php endif; ?>

                    <!-- TOMBOL LOGIN -->
                    <div class="d-grid">

                        <button
                            type="submit"
                            class="btn btn-primary">

                            <i class="bi bi-box-arrow-in-right me-2"></i>

                            <?= lang('Auth.loginAction') ?>

                        </button>

                    </div>

                </form>

                <!-- PEMBATAS -->
                <hr class="my-4">

                <!-- REGISTER -->
                <?php if ($config->allowRegistration): ?>

                    <div class="text-center mb-2">

                        <span class="text-muted">
                            <?= lang('Auth.needAnAccount') ?>
                        </span>

                        <a
                            href="<?= url_to('register') ?>"
                            class="text-decoration-none fw-semibold">

                            Daftar

                        </a>

                    </div>

                <?php endif; ?>

                <!-- LUPA PASSWORD -->
                <?php if ($config->activeResetter): ?>

                    <div class="text-center">

                        <a
                            href="<?= url_to('forgot') ?>"
                            class="text-decoration-none">

                            <?= lang('Auth.forgotYourPassword') ?>

                        </a>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

    <script>
        function togglePassword() {

            const password = document.getElementById('password');
            const icon = document.getElementById('passwordIcon');

            if (password.type === 'password') {

                password.type = 'text';

                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');

            } else {

                password.type = 'password';

                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');

            }
        }
    </script>

</body>

</html>