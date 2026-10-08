<?php helper('auth'); ?>

<!DOCTYPE html>
<html lang="id" data-bs-theme="auto">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Aktifitas Harian</title>

    <!-- BOOTSTRAP -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- BOOTSTRAP ICONS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet">

    <!-- DATATABLES -->
    <link
        href="https://cdn.datatables.net/v/bs5/dt-3.1.2/b-4.1.2/date-2.1.2/fc-6.1.1/sc-3.1.1/datatables.min.css"
        rel="stylesheet"
        integrity="sha384-my/Ea91wqTaDMpRukdw8luhUDyPsbh2r32KmKr9PuzvdOLAPd2qzPcZjqGe3PKng"
        crossorigin="anonymous">

</head>

<body class="bg-body">

<div class="container-fluid p-0">

    <!-- SIDEBAR -->
    <aside
        id="sidebar"
        class="position-fixed top-0 start-0 vh-100 bg-body border-end shadow-sm"
        style="
            width: 250px;
            z-index: 50;
            transform: translateX(0);
            transition: transform 0.7s ease;
        ">

        <!-- SIDEBAR HEADER -->
        <div
            class="d-flex align-items-center gap-2 px-3 border-bottom"
            style="height: 70px;">

            <img
                src="<?= base_url('assets/img/logo_sinsen_together_as_one.svg') ?>"
                alt="Logo"
                width="220"
                height="80"
                class="object-fit-contain">
        </div>

        <!-- SIDEBAR CONTENT -->
        <div class="p-3">

            <div class="text-body-secondary small fw-semibold mb-2 px-2">
                MENU UTAMA
            </div>

            <ul class="nav nav-pills flex-column gap-1">

                <!-- LAPORAN -->
                <li class="nav-item">

                    <a
                        href="<?= base_url('/home') ?>"
                        class="nav-link text-body-secondary d-flex align-items-center gap-1">
                        <i class="bi bi-journal-text fs-5"></i>
                        <span>
                            Laporan Harian
                        </span>
                    </a>
                </li>

                <!-- PROFIL -->
                <li class="nav-item">
                    <a
                        href="#"
                        class="nav-link text-body-secondary d-flex align-items-center gap-1"
                        data-bs-toggle="modal"
                        data-bs-target="#modalProfil">
                        <i class="bi bi-person fs-5"></i>
                        <span>
                            Profil
                        </span>
                    </a>
                </li>

                <!-- Kalender -->
                <li class="nav-item">
                    <a
                        href="#"
                        class="nav-link text-body-secondary d-flex align-items-center gap-1"
                        data-bs-toggle="modal"
                        data-bs-target="#modalProfil">
                        <i class="bi bi-calendar4-event"></i>
                        <span>
                            Kalender
                        </span>
                    </a>
                </li>

            </ul>

        </div>

        <!-- LOGOUT -->
        <div class="position-absolute bottom-0 start-0 w-100 p-2 border-top">

            <?php if (logged_in()): ?>

                <a
                    href="<?= url_to('logout') ?>"
                    class="nav-link text-body-danger d-flex align-items-center gap-1">
                    <i class="bi bi-box-arrow-right fs-5"></i>
                    <span>
                        Logout
                    </span>
                </a>

            <?php endif; ?>

        </div>

    </aside>

    <!-- MAIN WRAPPER -->
    <div
        id="mainWrapper"
        class="min-vh-100 d-flex flex-column"
        style="
            margin-left: 250px;
            transition: margin-left 0.7s ease;
        ">

        <!-- HEADER -->
        <header class="bg-body border-bottom sticky-top shadow-sm">

            <div
                class="d-flex align-items-center justify-content-between px-4"
                style="height: 70px;">

                <!-- LEFT -->
                <div class="d-flex align-items-center">

                    <!-- SIDEBAR TOGGLE -->
                    <button
                        type="button"
                        class="btn btn-outline-secondary me-3"
                        id="sidebarToggle">
                        <i class="bi bi-list fs-5"></i>
                    </button>

                    <!-- TITLE -->
                    <div>

                        <h5 class="mb-0 fw-semibold">
                            Laporan Aktifitas
                        </h5>

                    </div>

                </div>

                <!-- RIGHT -->
                <div class="d-flex align-items-center gap-4">

                    <!-- TANGGAL & WAKTU -->
                    <div class="text-end">

                        <div
                            class="fw-semibold"
                            id="tanggalHari">
                            -
                        </div>

                        <small
                            class="text-body-secondary"
                            id="waktuSekarang">
                            -
                        </small>

                </div>

                    <!-- THEME -->
        <div class="dropdown">

            <button
                class="btn btn-outline-secondary dropdown-toggle"
                id="themeToggle"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                <i id="themeIcon" class="bi bi-moon-fill"></i>
            </button>

            <div class="dropdown-menu dropdown-menu-end">

                <button
                    type="button"
                    class="dropdown-item theme-option"
                    data-theme="light">
                    <i class="bi bi-sun-fill me-2"></i>
                    Light
                </button>

                <button
                    type="button"
                    class="dropdown-item theme-option"
                    data-theme="dark">
                    <i class="bi bi-moon-fill me-2"></i>
                    Dark
                </button>

            </div>

        </div>
                    <!-- USER -->
                    <?php if (logged_in()): ?>

                        <div class="text-end border-start ps-4">
                            <small class="text-body">
                                <?= esc(user()->email) ?>
                            </small>
                        </div>

                    <?php endif; ?>

                </div>

            </div>

        </header>

        <!-- CONTENT -->
        <main class="flex-grow-1 p-4">
            <?= $this->renderSection('content') ?>
        </main>

        <!-- FOOTER -->
        <footer class="bg-body border-top text-center py-3">
            <small class="text-body-secondary">
                &copy; <?= date('Y') ?> Sinsen.
            </small>
        </footer>

    </div>

</div>

<!-- MODAL PROFIL -->
<div
    class="modal fade"
    id="modalProfil"
    tabindex="-1"
    aria-labelledby="modalProfilLabel"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="modalProfilLabel">
                    <i class="bi bi-person-circle me-2"></i>
                    Profil Pengguna
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>

            <!-- BODY -->
            <div class="modal-body">

                <div class="card border-0">

                    <div class="card-body text-center">

                        <!-- AVATAR -->
                        <div class="mb-3">

                            <div
                                class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center"
                                style="width: 70px; height: 70px;">
                                <i class="bi bi-person-fill fs-2"></i>
                            </div>

                        </div>

                        <?php if (logged_in()): ?>

                            <p class="text-body-secondary mb-0">
                                <?= esc(user()->email) ?>
                            </p>

                        <?php else: ?>

                            <h5 class="fw-bold">
                                Belum Login
                            </h5>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Tutup
                </button>

            </div>

        </div>

    </div>

</div>

<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- BOOTSTRAP JS -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

<!-- DATATABLES JS -->
<script
    src="https://cdn.datatables.net/v/bs5/dt-3.1.2/b-4.1.2/date-2.1.2/fc-6.1.1/sc-3.1.1/datatables.min.js"
    integrity="sha384-RfA7QN5CWz6wsYkuxhDGST8/eZffjFOwfgG/wYJilguTsevs0j9hMazVdnBIGBua"
    crossorigin="anonymous">
</script>

<!-- BASE URL -->
<script>
    const BASE_URL = "<?= base_url() ?>";
</script>

<!-- JAVASCRIPT PROJECT -->
<script src="<?= base_url('assets/js/laporan.js') ?>"></script>

</body>

</html>