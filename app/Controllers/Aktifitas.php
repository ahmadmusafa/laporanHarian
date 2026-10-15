<?php

namespace App\Controllers;

use App\Models\AktifitasModel;

class Aktifitas extends BaseController
{
    protected $aktifitasModel;

    public function __construct()
    {
        helper('auth');
        $this->aktifitasModel = new AktifitasModel();
    }

    // Menampilkan laporan milik pengguna yang login
    public function index()
    {
        $userId = user_id();

        if (!$userId) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Aktifitas Harian',
            'aktivitas' => $this->aktifitasModel
                ->where('user_id', $userId)
                ->orderBy('tanggal', 'DESC')
                ->findAll()
        ];

        return view('aktifitas', $data);
    }

    // Menyimpan laporan baru
    public function simpan()
    {
        $userId = user_id();

        if (!$userId) {
            return redirect()->to('/login');
        }

        $data = [
            'user_id'          => $userId,
            'tanggal'          => $this->request->getPost('tanggal'),
            'uraian_aktifitas' => $this->request->getPost('uraian_aktifitas'),
            'pembelajaran'     => $this->request->getPost('pembelajaran'),
            'kendala'          => $this->request->getPost('kendala')
        ];

        $this->aktifitasModel->insert($data);

        return redirect()->to('/aktifitas')
            ->with('success', 'Laporan berhasil ditambahkan.');
    }

    // Mengambil laporan berdasarkan ID dan pemilik
    public function getData($id)
    {
        $userId = user_id();

        if (!$userId) {
            return $this->response->setStatusCode(401)->setJSON([
                'status' => false,
                'message' => 'Silakan login terlebih dahulu.'
            ]);
        }

        $data = $this->aktifitasModel
            ->where('user_id', $userId)
            ->where('id_aktifitas', $id)
            ->first();

        if (!$data) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => false,
                'message' => 'Data tidak ditemukan atau bukan milik Anda.'
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'data' => $data
        ]);
    }

    // Mengubah laporan milik pengguna yang login
    public function update($id)
    {
        $userId = user_id();

        if (!$userId) {
            return redirect()->to('/login');
        }

        $laporan = $this->aktifitasModel
            ->where('user_id', $userId)
            ->where('id_aktifitas', $id)
            ->first();

        if (!$laporan) {
            return redirect()->to('/aktifitas')
                ->with('error', 'Data tidak ditemukan atau bukan milik Anda.');
        }

        $data = [
            'tanggal'          => $this->request->getPost('tanggal'),
            'uraian_aktifitas' => $this->request->getPost('uraian_aktifitas'),
            'pembelajaran'     => $this->request->getPost('pembelajaran'),
            'kendala'          => $this->request->getPost('kendala')
        ];

        $this->aktifitasModel->update($id, $data);

        return redirect()->to('/aktifitas')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    // Menghapus laporan milik pengguna yang login
    public function hapus($id)
    {
        $userId = user_id();

        if (!$userId) {
            return redirect()->to('/login');
        }

        $laporan = $this->aktifitasModel
            ->where('user_id', $userId)
            ->where('id_aktifitas', $id)
            ->first();

        if (!$laporan) {
            return redirect()->to('/aktifitas')
                ->with('error', 'Data tidak ditemukan atau bukan milik Anda.');
        }

        $this->aktifitasModel->delete($id);

        return redirect()->to('/aktifitas')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}