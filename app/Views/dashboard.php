<?php
/** @var array|null $laporanHariIni */
?>

<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">

    <?php if (!$laporanHariIni) : ?>

        <div class="card">
            <div class="card-body">

                <h5 class="mb-3">
                    <i class="bi bi-pencil-square me-2"></i>
                    Laporan Hari Ini
                </h5>

                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    Anda belum mengisi laporan hari ini.
                </div>

                <form id="formLaporanHariIni">

                    <input type="hidden"
                           name="tanggal"
                           value="<?= date('Y-m-d') ?>">

                    <div class="mb-3">
                        <label class="form-label">
                            Uraian Aktifitas
                        </label>

                        <textarea name="uraian_aktifitas"
                                  class="form-control"
                                  rows="4"
                                  minlength="100"
                                  required></textarea>

                        <small class="text-muted">
                            Minimal 100 karakter.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Pembelajaran
                        </label>

                        <textarea name="pembelajaran"
                                  class="form-control"
                                  rows="4"
                                  minlength="100"
                                  required></textarea>

                        <small class="text-muted">
                            Minimal 100 karakter.
                        </small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Kendala
                        </label>

                        <textarea name="kendala"
                                  class="form-control"
                                  rows="4"
                                  minlength="100"
                                  required></textarea>

                        <small class="text-muted">
                            Minimal 100 karakter.
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>
                        Simpan Laporan
                    </button>

                </form>

            </div>
        </div>

    <?php else : ?>

        <div class="card">
            <div class="card-body">

                <h5 class="mb-3">
                    <i class="bi bi-check-circle text-success me-2"></i>
                    Laporan Hari Ini
                </h5>

                <div class="alert alert-success">
                    Laporan hari ini sudah diisi, tatapi belum di kirim ke grup IT SINSEN dan MagangHub
                </div>

                <div class="mb-3">
                    <strong>Uraian Aktifitas:</strong>
                    <p class="mt-1">
                        <?= nl2br(esc($laporanHariIni['uraian_aktifitas'])) ?>
                    </p>
                </div>

                <div class="mb-3">
                    <strong>Pembelajaran:</strong>
                    <p class="mt-1">
                        <?= nl2br(esc($laporanHariIni['pembelajaran'])) ?>
                    </p>
                </div>

                <div class="mb-3">
                    <strong>Kendala:</strong>
                    <p class="mt-1">
                        <?= nl2br(esc($laporanHariIni['kendala'])) ?>
                    </p>
                </div>
            </div>
        </div>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>