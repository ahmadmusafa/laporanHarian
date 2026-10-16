<?php

namespace App\Controllers;

use App\Models\AktifitasModel;
use App\Models\LampiranModel;

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

    private function kembali(string $jenis, string $pesan)
    {
        return redirect()->to(site_url('lampiran'))
            ->with($jenis, $pesan);
    }

    public function index()
    {
        $userId = user_id();

        if (!$userId) {
            return redirect()->to(site_url('login'));
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
            'title' => 'Lampiran Dokumen',
            'lampiran' => $lampiran,
            'aktifitas' => $aktifitas,
        ]);
    }

    public function tambah()
    {
        $userId = user_id();

        if (!$userId) {
            return redirect()->to(site_url('login'));
        }

        $rules = [
            'nama_dokumen' => 'required|max_length[150]',
            'file' => [
                'rules' => [
                    'uploaded[file]',
                    'max_size[file,2048]',
                    'ext_in[file,pdf,doc,docx,jpg,jpeg,png]',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return $this->kembali(
                'error',
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
                return $this->kembali(
                    'error',
                    'Aktivitas tidak ditemukan atau bukan milik Anda.'
                );
            }
        }

        $file = $this->request->getFile('file');

        $folder = WRITEPATH . 'uploads/lampiran/';

        if (!is_dir($folder) && !mkdir($folder, 0750, true)) {
            return $this->kembali('error', 'Folder upload gagal dibuat.');
        }

        $namaAsli = $file->getClientName();
        $namaSimpan = $file->getRandomName();

        if (!$file->move($folder, $namaSimpan)) {
            return $this->kembali('error', 'File gagal diunggah.');
        }

        $berhasil = $this->lampiranModel->insert([
            'user_id' => $userId,
            'id_aktifitas' => $idAktifitas,
            'nama_dokumen' => trim($this->request->getPost('nama_dokumen')),
            'nama_file' => $namaAsli,
            'file_path' => $namaSimpan,
            'keterangan' => $this->request->getPost('keterangan'),
        ]);

        if (!$berhasil) {
            if (is_file($folder . $namaSimpan)) {
                unlink($folder . $namaSimpan);
            }

            return $this->kembali('error', 'Data lampiran gagal disimpan.');
        }

        return $this->kembali('success', 'Dokumen berhasil diunggah.');
    }

    public function download(int $id)
    {
        $userId = user_id();

        if (!$userId) {
            return redirect()->to(site_url('login'));
        }

        $dokumen = $this->lampiranModel
            ->where('id_lampiran', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$dokumen) {
            return $this->kembali('error', 'Dokumen tidak ditemukan.');
        }

        $path = WRITEPATH . 'uploads/lampiran/'
            . basename($dokumen['file_path']);

        if (!is_file($path)) {
            return $this->kembali('error', 'File lampiran tidak ditemukan.');
        }

        return $this->response
            ->download($path, null)
            ->setFileName($dokumen['nama_file']);
    }

    
public function hapus(int $id)
{
    $userId = $this->currentUserId();

    if (!$userId) {
        return redirect()->to(site_url('login'));
    }

    $dokumen = $this->lampiranModel
        ->where('id_lampiran', $id)
        ->where('user_id', $userId)
        ->first();

    if (!$dokumen) {
        return redirect()->to(site_url('lampiran'))
            ->with('error', 'Dokumen tidak ditemukan.');
    }

    $path = WRITEPATH . 'uploads/lampiran/'
        . basename($dokumen['file_path']);

    if (!$this->lampiranModel->delete($id)) {
        return redirect()->to(site_url('lampiran'))
            ->with('error', 'Dokumen gagal dihapus.');
    }

    if (is_file($path)) {
        unlink($path);
    }

    return redirect()->to(site_url('lampiran'))
        ->with('success', 'Dokumen berhasil dihapus.');
    }

}
