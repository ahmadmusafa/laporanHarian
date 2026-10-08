<?php

namespace App\Controllers;

use App\Models\AktifitasModel;

class Dashboard extends BaseController
{
    protected AktifitasModel $aktifitasModel;

    public function __construct()
    {
        $this->aktifitasModel = new AktifitasModel();
    }

    public function index()
    {
        $laporanHariIni = $this->aktifitasModel
            ->where('tanggal', date('Y-m-d'))
            ->first();

        $totalLaporan = $this->aktifitasModel->countAllResults();

        return view('dashboard', [
            'title'          => 'Dashboard',
            'laporanHariIni' => $laporanHariIni,
            'totalLaporan'   => $totalLaporan
        ]);
    }
}