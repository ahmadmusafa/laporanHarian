<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Dashboard
$routes->get('/', 'Dashboard::index', ['filter' => 'login']);
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'login']);

// Laporan Aktifitas
$routes->get('/home', 'Aktifitas::index', ['filter' => 'login']);

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

$routes->post(
    'aktifitas/hapus/(:num)',
    'Aktifitas::hapus/$1'
);