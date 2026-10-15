<?php

namespace App\Controllers;

class aktifitas extends BaseController
{
    public function index()
    {
        return view('aktifitas', [
            'title' => 'aktifitas'
        ]);
    }
}