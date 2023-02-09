<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'DashboardController::index');
$routes->get('/merek', 'MerekController::index');
$routes->get('/merek/detail/(:any)', 'MerekController::show/$1');
$routes->get('/merek/create', 'MerekController::create');
$routes->post('/merek/store', 'MerekController::store');
$routes->get('/merek/edit/(:any)', 'MerekController::edit/$1');
$routes->post('/merek/edited', 'MerekController::edited');
$routes->get('/merek/delete/(:any)', 'MerekController::delete/$1');

$routes->get('/mobil', 'MobilController::index');
$routes->get('/mobil/detail/(:any)', 'MobilController::show/$1');
$routes->get('/mobil/create', 'MobilController::create');
$routes->post('/mobil/store', 'MobilController::store');
$routes->get('/mobil/edit/(:any)', 'MobilController::edit/$1');
$routes->post('/mobil/edited', 'MobilController::edited');
$routes->get('/mobil/delete/(:any)', 'MobilController::delete/$1');

$routes->get('/supir', 'SupirController::index');
$routes->get('/supir/detail/(:any)', 'SupirController::show/$1');
$routes->get('/supir/create', 'SupirController::create');
$routes->post('/supir/store', 'SupirController::store');
$routes->get('/supir/edit/(:any)', 'SupirController::edit/$1');
$routes->post('/supir/edited', 'SupirController::edited');
$routes->get('/supir/delete/(:any)', 'SupirController::delete/$1');

$routes->get('/transaksi/masuk', 'TransaksiController::masuk');
$routes->get('/transaksi/keluar', 'TransaksiController::index');
$routes->get('/transaksi/detail/(:any)', 'TransaksiController::show/$1');
$routes->get('/transaksi/create', 'TransaksiController::create');
$routes->post('/transaksi/store', 'TransaksiController::store');
$routes->get('/transaksi/edit/(:any)', 'TransaksiController::edit/$1');
$routes->post('/transaksi/edited', 'TransaksiController::edited');
$routes->get('/transaksi/delete/(:any)', 'TransaksiController::delete/$1');
$routes->get('/transaksi/bulanan', 'TransaksiController::bulanan');
$routes->post('/transaksi/bulanan', 'TransaksiController::bulanan');
$routes->get('/transaksi/harian', 'TransaksiController::harian');
$routes->get('/transaksi/harian/cetak', 'TransaksiController::cetakharian');

$routes->get('/users/register', 'UsersController::hregister');
$routes->post('/users/registered', 'UsersController::register');

$routes->get('/users/login', 'UsersController::hlogin');
$routes->post('/users/logged', 'UsersController::login');
$routes->get('/users/logout', 'UsersController::logout');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
