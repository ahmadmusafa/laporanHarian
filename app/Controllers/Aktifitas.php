<?php

namespace App\Controllers;

use App\Models\AktifitasModel;

class Aktifitas extends BaseController
{
    protected $aktifitasModel;

    public function __construct()
    {
        $this->aktifitasModel = new AktifitasModel();
    }

    // Menampilkan semua data
    public function index()
    {
        $data = [
            'title' => 'Aktifitas Harian',
            'aktivitas' => $this->aktifitasModel
                ->orderBy('tanggal', 'DESC')
                ->findAll()
        ];

        return view('home', $data);
    }

    // Menyimpan data baru
    public function simpan()
    {
        $data = [
            'tanggal'          => $this->request->getPost('tanggal'),
            'uraian_aktifitas' => $this->request->getPost('uraian_aktifitas'),
            'pembelajaran'     => $this->request->getPost('pembelajaran'),
            'kendala'          => $this->request->getPost('kendala')
        ];

        $this->aktifitasModel->insert($data);

        return redirect()->to('/home')
            ->with('success', 'Laporan berhasil ditambahkan.');
    }

    // Mengambil satu data berdasarkan ID
    public function getData($id)
    {
        $data = $this->aktifitasModel->find($id);

        if (!$data) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'data' => $data
        ]);
    }

    // Mengubah data
    public function update($id)
    {
        $data = [
            'tanggal'          => $this->request->getPost('tanggal'),
            'uraian_aktifitas' => $this->request->getPost('uraian_aktifitas'),
            'pembelajaran'     => $this->request->getPost('pembelajaran'),
            'kendala'          => $this->request->getPost('kendala')
        ];

        $this->aktifitasModel->update($id, $data);

        return redirect()->to('/home')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    // Menghapus data
    public function hapus($id)
    {
        $this->aktifitasModel->delete($id);

        return redirect()->to('/home')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}