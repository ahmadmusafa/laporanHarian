<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
// $routes->get('/', 'Aktifitas::index');
// Halaman utama
$routes->get('/', 'Aktifitas::index', ['filter' => 'login']);

$routes->get('/home', 'Aktifitas::index', ['filter' => 'login']);

// CRUD
$routes->post('/aktifitas/simpan', 'Aktifitas::simpan');

$routes->get(
    '/aktifitas/data/(:num)',
    'Aktifitas::getData/$1'
);

$routes->post(
    '/aktifitas/update/(:num)',
    'Aktifitas::update/$1'
);

$routes->get(
    '/aktifitas/hapus/(:num)',
    'Aktifitas::hapus/$1'
);