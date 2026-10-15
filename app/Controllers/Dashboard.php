<?php

namespace App\Controllers;

use App\Models\AktifitasModel;

class Dashboard extends BaseController
{
    protected AktifitasModel $aktifitasModel;

    public function __construct()
    {
        helper('auth');
        $this->aktifitasModel = new AktifitasModel();
    }

    public function index()
    {
        $userId = user_id();

        // Pastikan pengguna sudah login
        if (!$userId) {
            return redirect()->to('/login');
        }

        // Mengambil laporan hari ini milik user yang login
        $laporanHariIni = $this->aktifitasModel
            ->where('user_id', $userId)
            ->where('tanggal', date('Y-m-d'))
            ->first();

        // Menghitung total laporan milik user yang login
        $totalLaporan = $this->aktifitasModel
            ->where('user_id', $userId)
            ->countAllResults();

        return view('dashboard', [
            'title'          => 'Dashboard',
            'laporanHariIni' => $laporanHariIni,
            'totalLaporan'   => $totalLaporan
        ]);
    }
}