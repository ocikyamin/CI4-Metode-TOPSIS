<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->post('login/cek', 'Login::Cek');


$routes->group('user', static function ($routes) {
    $routes->get('/', 'Users::index');
    $routes->get('akun', 'Users::Akun');
    $routes->get('add', 'Users::Add');
    $routes->get('edit', 'Users::Edit');
    $routes->post('save', 'Users::Save');
    $routes->post('update', 'Users::Update');
    $routes->post('delete', 'Users::Del');
    $routes->get('logout', 'Users::Logout');
});


$routes->group('anggota', static function ($routes) {
    $routes->get('/', 'Anggota::index');
    $routes->get('add', 'Anggota::Add');
    $routes->get('edit', 'Anggota::Edit');
    $routes->post('save', 'Anggota::Save');
    $routes->post('delete', 'Anggota::Del');
});

// Kriteria 
$routes->group('kriteria', static function ($routes) {
    $routes->get('/', 'Kriteria::index');
    $routes->get('add', 'Kriteria::Add');
    $routes->get('edit', 'Kriteria::Edit');
    $routes->post('save', 'Kriteria::Save');
    $routes->post('delete', 'Kriteria::Del');
});

// Alternatif 
$routes->group('alternatif', static function ($routes) {
    $routes->get('/', 'Alternatif::index');
    $routes->get('add', 'Alternatif::Add');
    // $routes->get('edit', 'Alternatif::Edit');
    $routes->post('save', 'Alternatif::Save');
    $routes->post('get-nilai', 'Alternatif::getDataAlternatifByAnggota');
    $routes->post('delete', 'Alternatif::Del');
});

// Topsis 
$routes->group('topsis', static function ($routes) {
    $routes->get('/', 'Topsis::index');
    $routes->get('hasil', 'Topsis::Hasil');
});