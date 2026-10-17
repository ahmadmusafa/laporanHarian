
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid py-3">

    <!-- Notifikasi -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            <?= esc(session()->getFlashdata('success')) ?>
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>
            <?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close"
                    data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    <?php endif; ?>

    <!-- Tabel Lampiran -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="tabelLampiran"
                       class="table table-striped table-hover align-middle w-100">
                    <thead>
                        <tr>
                            <th>Nama Dokumen</th>
                            <th>Aktivitas</th>
                            <th>Tanggal Upload</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($lampiran as $item): ?>
                            <tr>
                            
                                <td>
                                    <div class="fw-semibold">
                                        <?= esc($item['nama_dokumen']) ?>
                                    </div>
                                    <small class="text-muted">
                                        <?= esc($item['nama_file']) ?>
                                    </small>
                                </td>

                                <td>
                                    <?= esc(
                                        $item['uraian_aktifitas']
                                        ?? 'Dokumen mandiri'
                                    ) ?>
                                </td>

                                <td>
                                    <?= esc($item['created_at'] ?? '-') ?>
                                </td>

                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="<?= site_url('lampiran/download/' . $item['id_lampiran']) ?>"
                                           class="btn btn-sm btn-outline-primary"
                                           title="Download">
                                            <i class="bi bi-download"></i>
                                        </a>

                                        <button 
                                            type="button"
                                            class="btn btn-sm btn-outline-danger btnHapus"
                                            data-id="<?= $item['id_lampiran'] ?>"
                                            data-nama="<?= esc($item['nama_dokumen']) ?>"
                                            title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Lampiran
<div class="modal fade" id="modalLampiran" tabindex="-1"
     aria-labelledby="judulModalLampiran" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form action="<?= site_url('lampiran/tambah') ?>"
                  method="post" enctype="multipart/form-data">

                <?= csrf_field() ?>

                <div class="modal-header">
                    <h5 class="modal-title" id="judulModalLampiran">
                        <i class="bi bi-paperclip me-2"></i>Tambah Lampiran
                    </h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nama_dokumen" class="form-label">
                            Nama Dokumen
                        </label>
                        <input type="text" name="nama_dokumen"
                               id="nama_dokumen" class="form-control"
                               maxlength="150"
                               placeholder="Masukkan nama dokumen" required>
                    </div>

                    <div class="mb-3">
                        <label for="id_aktifitas" class="form-label">
                            Aktivitas
                        </label>
                        <select name="id_aktifitas" id="id_aktifitas"
                                class="form-select">
                            <option value="">Pilih aktifitas</option>

                            <?php foreach ($aktifitas as $aktivitasItem): ?>
                                <option value="<?= $aktivitasItem['id_aktifitas'] ?>">
                                    <?= esc($aktivitasItem['tanggal']) ?>
                                    -
                                    <?= esc($aktivitasItem['uraian_aktifitas']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text">
                            Pilih aktivitas jika dokumen terkait laporan harian.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label">Pilih File</label>
                        <input type="file" name="file" id="file"
                               class="form-control"
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                               required>
                        <div class="form-text">
                            PDF, DOC, DOCX, JPG, JPEG, atau PNG. Maksimal 2 MB.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="keterangan" class="form-label">
                            Keterangan
                        </label>
                        <textarea name="keterangan" id="keterangan"
                                  class="form-control" rows="3"
                                  placeholder="Keterangan dokumen"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i>Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div> -->

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="modalHapusLampiran" tabindex="-1"
     aria-labelledby="judulModalHapus" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="judulModalHapus">
                    Hapus Lampiran
                </h5>
                <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <form id="formHapusLampiran" method="post" action="">
                <?= csrf_field() ?>

                <div class="modal-body">
                    Apakah kamu yakin ingin menghapus
                    <strong id="namaLampiranHapus"></strong>?
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        Hapus
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/lampiran.js') ?>"></script>
<?= $this->endSection() ?>