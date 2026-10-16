<?php

namespace App\Controllers;

use App\Models\LampiranModel;
use App\Models\AktifitasModel;

class Lampiran extends BaseController
{
    protected LampiranModel $lampiranModel;
    protected AktifitasModel $aktifitasModel;

    public function __construct()
    {
        helper('auth');

        $this->lampiranModel = new LampiranModel();
        $this->aktifitasModel = new AktifitasModel();
    }

    // Memastikan pengguna sudah login
    private function currentUserId()
    {
        $userId = user_id();

        if (!$userId) {
            return null;
        }

        return $userId;
    }

    // Format respons AJAX
    private function responseJson(bool $status, string $message, array $data = [])
    {
        return $this->response->setJSON([
            'status'  => $status,
            'message' => $message,
            'data'    => $data,
        ]);
    }

    // Daftar dokumen
    public function index()
    {
        $userId = $this->currentUserId();

        if (!$userId) {
            return redirect()->to('/login');
        }

        $lampiran = $this->lampiranModel
            ->select('lampiran.*, aktifitas.uraian_aktifitas')
            ->join(
                'aktifitas',
                'aktifitas.id_aktifitas = lampiran.id_aktifitas',
                'left'
            )
            ->where('lampiran.user_id', $userId)
            ->orderBy('lampiran.created_at', 'DESC')
            ->findAll();

        $aktifitas = $this->aktifitasModel
            ->where('user_id', $userId)
            ->orderBy('tanggal', 'DESC')
            ->findAll();

        return view('lampiran', [
            'title'    => 'Lampiran Dokumen',
            'lampiran' => $lampiran,
            'aktifitas' => $aktifitas,
        ]);
    }

    // Upload dokumen baru
    public function tambah()
    {
        $userId = $this->currentUserId();

        if (!$userId) {
            return $this->responseJson(false, 'Silakan login kembali.');
        }

        $rules = [
            'nama_dokumen' => 'required|max_length[150]',
            'file' => [
                'label' => 'Dokumen',
                'rules' => [
                    'uploaded[file]',
                    'max_size[file,2048]',
                    'ext_in[file,pdf,doc,docx,jpg,jpeg,png]',
                    'mime_in[file,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/jpeg,image/png]',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return $this->responseJson(
                false,
                implode(' ', $this->validator->getErrors())
            );
        }

        $idAktifitas = $this->request->getPost('id_aktifitas');
        $idAktifitas = $idAktifitas !== '' ? $idAktifitas : null;

        // Pastikan aktivitas yang dipilih milik pengguna
        if ($idAktifitas !== null) {
            $aktivitas = $this->aktifitasModel
                ->where('id_aktifitas', $idAktifitas)
                ->where('user_id', $userId)
                ->first();

            if (!$aktivitas) {
                return $this->responseJson(
                    false,
                    'Aktifitas tidak ditemukan atau bukan milik Anda.'
                );
            }
        }

        $file = $this->request->getFile('file');

        $folder = WRITEPATH . 'uploads/lampiran/';

        if (!is_dir($folder)) {
            mkdir($folder, 0750, true);
        }

        $namaFile = $file->getClientName();
        $namaSimpan = $file->getRandomName();

        if (!$file->move($folder, $namaSimpan)) {
            return $this->responseJson(
                false,
                'Gagal menyimpan file.'
            );
        }

        $data = [
            'user_id'      => $userId,
            'id_aktifitas' => $idAktifitas,
            'nama_dokumen' => trim(
                $this->request->getPost('nama_dokumen')
            ),
            'nama_file'    => $namaFile,
            'file_path'    => $namaSimpan,
            'keterangan'   => $this->request->getPost('keterangan'),
        ];

        if (!$this->lampiranModel->insert($data)) {
            // Hapus file jika penyimpanan database gagal
            if (is_file($folder . $namaSimpan)) {
                unlink($folder . $namaSimpan);
            }

            return $this->responseJson(
                false,
                'Gagal menyimpan data lampiran.'
            );
        }

        return $this->responseJson(
            true,
            'Dokumen berhasil diunggah.'
        );
    }

    // Edit informasi dokumen
    public function update(int $id)
    {
        $userId = $this->currentUserId();

        if (!$userId) {
            return $this->responseJson(false, 'Silakan login kembali.');
        }

        $dokumen = $this->lampiranModel
            ->where('id_lampiran', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$dokumen) {
            return $this->responseJson(
                false,
                'Dokumen tidak ditemukan.'
            );
        }

        $rules = [
            'nama_dokumen' => 'required|max_length[150]',
        ];

        if (!$this->validate($rules)) {
            return $this->responseJson(
                false,
                implode(' ', $this->validator->getErrors())
            );
        }

        $idAktifitas = $this->request->getPost('id_aktifitas');
        $idAktifitas = $idAktifitas !== '' ? $idAktifitas : null;

        if ($idAktifitas !== null) {
            $aktivitas = $this->aktifitasModel
                ->where('id_aktifitas', $idAktifitas)
                ->where('user_id', $userId)
                ->first();

            if (!$aktivitas) {
                return $this->responseJson(
                    false,
                    'Aktifitas tidak ditemukan atau bukan milik Anda.'
                );
            }
        }

        $berhasil = $this->lampiranModel->update($id, [
            'id_aktifitas' => $idAktifitas,
            'nama_dokumen' => trim(
                $this->request->getPost('nama_dokumen')
            ),
            'keterangan' => $this->request->getPost('keterangan'),
        ]);

        if (!$berhasil) {
            return $this->responseJson(
                false,
                'Gagal memperbarui dokumen.'
            );
        }

        return $this->responseJson(
            true,
            'Informasi dokumen berhasil diperbarui.'
        );
    }

    // Unduh dokumen
    public function download(int $id)
    {
        $userId = $this->currentUserId();

        if (!$userId) {
            return redirect()->to('/login');
        }

        $dokumen = $this->lampiranModel
            ->where('id_lampiran', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$dokumen) {
            return $this->response->setStatusCode(404)
                ->setBody('Dokumen tidak ditemukan.');
        }

        $path = WRITEPATH . 'uploads/lampiran/'
            . basename($dokumen['file_path']);

        if (!is_file($path)) {
            return $this->response->setStatusCode(404)
                ->setBody('File tidak ditemukan.');
        }

        return $this->response->download(
            $path,
            null
        )->setFileName($dokumen['nama_file']);
    }

    // Hapus dokumen
    public function delete(int $id)
    {
        $userId = $this->currentUserId();

        if (!$userId) {
            return $this->responseJson(false, 'Silakan login kembali.');
        }

        $dokumen = $this->lampiranModel
            ->where('id_lampiran', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$dokumen) {
            return $this->responseJson(
                false,
                'Dokumen tidak ditemukan.'
            );
        }

        $path = WRITEPATH . 'uploads/lampiran/'
            . basename($dokumen['file_path']);

        if (!$this->lampiranModel->delete($id)) {
            return $this->responseJson(
                false,
                'Gagal menghapus data dokumen.'
            );
        }

        if (is_file($path)) {
            unlink($path);
        }

        return $this->responseJson(
            true,
            'Dokumen berhasil dihapus.'
        );
    }
}
