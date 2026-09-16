<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'AuthController::login');

// Autentikasi
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::attempt');
$routes->post('logout', 'AuthController::logout');

// Halaman yang wajib login
$routes->group('', ['filter' => 'auth'], static function (RouteCollection $routes) {
    $routes->get('dashboard', 'DashboardController::index');

    // Data Barang
    $routes->get('items', 'ItemController::index');
    $routes->get('items/create', 'ItemController::create');
    $routes->post('items/store', 'ItemController::store');
    $routes->get('items/edit/(:num)', 'ItemController::edit/$1');
    $routes->post('items/update/(:num)', 'ItemController::update/$1');
    $routes->get('items/show/(:num)', 'ItemController::show/$1');
    $routes->post('items/delete/(:num)', 'ItemController::delete/$1');

    // Data Peminjam
    $routes->get('borrowers', 'BorrowerController::index');
    $routes->get('borrowers/create', 'BorrowerController::create');
    $routes->post('borrowers/store', 'BorrowerController::store');
    $routes->get('borrowers/edit/(:num)', 'BorrowerController::edit/$1');
    $routes->post('borrowers/update/(:num)', 'BorrowerController::update/$1');
    $routes->get('borrowers/show/(:num)', 'BorrowerController::show/$1');
    $routes->post('borrowers/delete/(:num)', 'BorrowerController::delete/$1');

    // Peminjaman
    $routes->get('borrowings', 'BorrowingController::index');
    $routes->get('borrowings/create', 'BorrowingController::create');
    $routes->post('borrowings/store', 'BorrowingController::store');
    $routes->get('borrowings/show/(:num)', 'BorrowingController::show/$1');

    // Pengembalian
    $routes->get('borrowings/return', 'BorrowingController::returnIndex');
    $routes->post('borrowings/return/(:num)', 'BorrowingController::processReturn/$1');

    // Riwayat
    $routes->get('history', 'HistoryController::index');
});
