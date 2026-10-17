<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                Daftar Laporan Harian
            </h4>
        </div>

        <!-- TOMBOL TAMBAH -->
        <button
            type="button"
            class="btn btn-danger"
            data-bs-toggle="modal"
            data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-1"></i>
            Tambah Laporan
        </button>

    </div>

    <!-- ALERT -->

    <?php if (session()->getFlashdata('success')) : ?>

        <div class="alert alert-success alert-dismissible fade show">

            <i class="bi bi-check-circle me-2"></i>

            <?= session()->getFlashdata('success') ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    <?php endif; ?>


    <!-- TABLE -->
<div class="card laporan-card">

    <div class="card-body p-4">

        <div class="table-responsive">

            <table
                id="tabelLaporan"
                class="table table-hover align-middle">

            <thead>
                <tr>
                    <!-- <th><input type="checkbox" id="selectAll"></th> -->
                    <th width="3%">No</th>
                    <th width="12%">Tanggal</th>
                    <th>Uraian Aktifitas</th>
                    <th>Pembelajaran</th>
                    <th>Kendala</th>
                    <!-- <th>Lampiran</th> -->
                    <th width="5%" class="text-center">Aksi</th>
                </tr>
            </thead>

    <tbody>

        <?php if (!empty($aktivitas)) : ?>
        <?php $no = 1; ?>
        <?php foreach ($aktivitas as $item) : ?>

            <tr>
                <td class="text-center">
                    <?= $no++ ?>
                </td>

                <td>
                    <span class="tanggal">
                        <i class="bi bi-calendar3 me-1"></i>
                        <?= date('d/m/y', strtotime($item['tanggal'])) ?>
                    </span>
                </td>
                
                <td>
                    <?php
                    $teks = $item['uraian_aktifitas'];
                    $id = 'uraian-' . $item['id_aktifitas'];?>
                    <?= esc(mb_substr($teks, 0, 100)) ?>

                    <?php if (mb_strlen($teks) > 100): ?>
                    <span id="<?= $id ?>" class="d-none">
                        <?= esc(mb_substr($teks, 100)) ?>
                    </span>
                    <button type="button"
                        class="btn btn-link btn-sm p-0 read-more"
                        data-target="<?= $id ?>">
                        Selengkapnya
                    </button>
                    <?php endif; ?>
                </td>

                <td>
                    <?php
                    $teks = $item['pembelajaran'];
                    $id = 'pembelajaran-' . $item['id_aktifitas'];?>
                    <?= esc(mb_substr($teks, 0, 100)) ?>

                    <?php if (mb_strlen($teks) > 100): ?>
                    <span id="<?= $id ?>" class="d-none">
                        <?= esc(mb_substr($teks, 100)) ?>
                    </span>
                    <button type="button"
                        class="btn btn-link btn-sm p-0 read-more"
                        data-target="<?= $id ?>">
                        Selengkapnya
                    </button>
                    <?php endif; ?>
                </td>

                <td>
                    <?php
                    $teks = $item['kendala'];
                    $id = 'kendala-' . $item['id_aktifitas'];?>
                    <?= esc(mb_substr($teks, 0, 100)) ?>

                    <?php if (mb_strlen($teks) > 100): ?>
                    <span id="<?= $id ?>" class="d-none">
                        <?= esc(mb_substr($teks, 100)) ?>
                    </span>
                    <button type="button"
                        class="btn btn-link btn-sm p-0 read-more"
                        data-target="<?= $id ?>">
                        Selengkapnya
                    </button>
                    <?php endif; ?>
                </td>

                <!-- <td>
                    <?= !empty($item['lampiran'])
                    ? esc($item['lampiran'])
                    : '-' ?>
                </td> -->

                <td class="text-center">
                    <div class="d-flex justify-content-center gap-1">

                        <!-- EDIT -->
                        <button
                            type="button"
                            class="btn btn-sm btn-warning btn-edit"
                            data-id="<?= $item['id_aktifitas'] ?>"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEdit">
                            <i class="bi bi-pencil-square"></i>
                        </button>

                        <!-- HAPUS -->
                        <button
                            type="button"
                            class="btn btn-sm btn-danger btn-hapus"
                            data-id="<?= $item['id_aktifitas'] ?>"
                            data-bs-toggle="modal"
                            data-bs-target="#modalHapus">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </div>
                </td>

            </tr>

                    <?php endforeach; ?>
                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<!-- MODAL TAMBAH -->

<div
    class="modal fade"
    id="modalTambah"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content">

            <form
        id="formTambah"
    action="<?= site_url('aktifitas/simpan') ?>"
    method="post"
    enctype="multipart/form-data">

    <?= csrf_field() ?>

                <div class="modal-header">

                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle me-2"></i>
                        Tambah Laporan
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">
                    <!-- Tanggal -->
                    <div class="mb-3">
                        <label class="form-label">
                            <strong>Tanggal</strong>
                        </label>
                        <input
                            type="date"
                            name="tanggal"
                            class="form-control"
                            value="<?= date('Y-m-d') ?>"
                            required>
                    </div>

                    <!-- Uraian -->
                    <div class="mb-3">
                        <label class="form-label">
                            <strong>Uraian Aktifitas</strong>
                        </label>
                        <textarea
                            name="uraian_aktifitas"
                            class="form-control"
                            rows="2"
                            minlength="100"
                            placeholder="Tuliskan aktifitas hari ini..."
                            required></textarea>
                    </div>

                    <!-- Pembelajaran -->
                    <div class="mb-3">
                        <label class="form-label">
                            <strong>Pembelajaran</strong>
                        </label>
                        <textarea
                            name="pembelajaran"
                            class="form-control"
                            rows="2"
                            minlength="100"
                            placeholder="Apa yang dipelajari hari ini?"
                            required></textarea>
                    </div>

                    <!-- Kendala -->
                    <div class="mb-3">
                        <label class="form-label">
                            <strong>Kendala</strong>
                        </label>
                        <textarea
                            name="kendala"
                            class="form-control"
                            rows="2"
                            minlength="100"
                            placeholder="Tuliskan kendala selama pembelajaran"
                            required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="lampiran" class="form-label">
                            <strong>Dokumen (Opsional)</strong>
                        </label>

                        <input
                            type="file"
                            name="lampiran[]"
                            id="lampiran"
                            class="form-control"
                            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                            multiple
                            >
                        <div class="form-text">
                            Bisa memilih beberapa file sekaligus. Maksimal 2 MB per file.
                        </div>
                    </div>  

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="btn btn-danger">
                        <i class="bi bi-save me-1"></i>
                        Simpan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- MODAL EDIT -->

<div
    class="modal fade"
    id="modalEdit"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <form
                id="formEdit"
                method="post">

                <?= csrf_field() ?>

                <div class="modal-header">

                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square me-2"></i>
                        Edit Laporan
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Tanggal
                        </label>

                        <input
                            type="date"
                            id="edit_tanggal"
                            name="tanggal"
                            class="form-control"
                            required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Uraian Aktifitas
                        </label>

                        <textarea
                            id="edit_uraian"
                            name="uraian_aktifitas"
                            class="form-control"
                            rows="3"
                            required></textarea>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Pembelajaran
                        </label>

                        <textarea
                            id="edit_pembelajaran"
                            name="pembelajaran"
                            class="form-control"
                            rows="2"
                            required></textarea>

                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Kendala
                        </label>
                        <textarea
                            id="edit_kendala"
                            name="kendala"
                            class="form-control"
                            rows="2"></textarea>
                    </div>

                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button
                        type="submit"
                        class="btn btn-warning">
                        <i class="bi bi-save me-1"></i>
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<!-- MODAL HAPUS -->

<div
    class="modal fade"
    id="modalHapus"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    <i class="bi bi-exclamation-triangle text-danger me-2"></i>
                    Konfirmasi Hapus
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body text-center">

                <i
                    class="bi bi-trash3 text-danger"
                    style="font-size: 50px;">
                </i>

                <h5 class="mt-3">
                    Hapus laporan ini?
                </h5>

                <p class="text-muted mb-0">
                    Data yang dihapus tidak dapat dikembalikan.
                </p>

            </div>

            <div class="modal-footer justify-content-center">

                <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Batal
                </button>

                
<form id="formHapus" method="post">
    <?= csrf_field() ?>

    <button type="submit" class="btn btn-danger">
        <i class="bi bi-trash3 me-1"></i>
        Ya, Hapus
    </button>
</form>


            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>