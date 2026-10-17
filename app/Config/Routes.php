<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Dashboard
$routes->get('/', 'Dashboard::index', ['filter' => 'login']);
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'login']);

// Laporan Aktifitas
$routes->get('/aktifitas', 'Aktifitas::index', ['filter' => 'login']);


// Routes Lampiran
$routes->group('lampiran', ['filter' => 'login'], static function ($routes) {
    $routes->get('/', 'Lampiran::index');
    $routes->post('tambah', 'Lampiran::tambah');
    $routes->post('update/(:num)', 'Lampiran::update/$1');
    $routes->get('download/(:num)', 'Lampiran::download/$1');
   $routes->post('delete/(:num)', 'Lampiran::delete/$1');
});

// CRUD
$routes->post('aktifitas/simpan', 'Aktifitas::simpan');

$routes->get(
    'aktifitas/data/(:num)',
    'Aktifitas::getData/$1'
);

$routes->post(
    'aktifitas/update/(:num)',
    'Aktifitas::update/$1'
);

$routes->get(
    'aktifitas/hapus/(:num)',
    'Aktifitas::hapus/$1'
);