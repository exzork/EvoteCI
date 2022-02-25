<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/** 
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories 

$routes->get('/home', 'Home::index');

$routes->get('user/event', 'User::event', ['filter' => 'authUser']);
$routes->get('user', 'User::index', ['filter' => 'authUserLog']);
//$routes->get('/');
//user 
$routes->get('/', 'User::index', ['filter' => 'authUserLog']);
$routes->get('/user/pilih_v/(:alphanum)', 'User::pilih_v/$1', ['filter' => 'authUser']);
$routes->get('/user/pilih_u/(:alphanum)/(:num)', 'User::pilih_u/$1/$2', ['filter' => 'authUser']);
$routes->post('/user/pilih', 'User::pilih', ['filter' => 'authUser']);
$routes->get('/user/forget', 'User::forgotPassword');
$routes->get('/user/password/(:alphanum)', 'User::changeForget/$1');
$routes->post('/user/password/(:alphanum)', 'User::changeForget/$1');
//$routes->get('/user/masuk_v', 'User::masuk_v', ['filter' => 'authUserLog']);
//$routes->get('/user/daftar_v', 'User::daftar_v', ['filter' => 'authUserLog']);
//panitia
$routes->get('/panitia', "Panitia::event", ['filter' => 'authPanitia']);
$routes->get('/panitia/event', "Panitia::event", ['filter' => 'authPanitia']);
//panitia event
$routes->get('/panitia/get_event', "Panitia::get_event", ['filter' => 'authPanitia']);
//panitia calon
$routes->get('/panitia/get_user/(:alphanum)', "Panitia::get_user/$1", ['filter' => 'authPanitia']);
$routes->get('/panitia/calon/(:alphanum)/(:num)', "Panitia::calon/$1/$2", ['filter' => 'authPanitia']);
$routes->get('/panitia/get_calon/(:alphanum)/(:alphanum)', "Panitia::get_calon/$1/$2", ['filter' => 'authPanitia']);
$routes->post('/panitia/add_calon', "Panitia::add_calon", ['filter' => 'authPanitia']);
$routes->get('/panitia/edit_calon_v/(:alphanum)', "Panitia::edit_calon_v/$1", ['filter' => 'authPanitia']);
$routes->post('/panitia/edit_calon/(:alphanum)', "Panitia::edit_calon/$1", ['filter' => 'authPanitia']);
$routes->get('/panitia/delete_calon/(:alphanum)', "Panitia::delete_calon/$1", ['filter' => 'authPanitia']);
//panitia verify
$routes->get('/panitia/verif_v/(:alphanum)', "Panitia::verif_v/$1", ['filter' => 'authPanitia']);
$routes->get('/panitia/verif/(:alphanum)', "Panitia::verif/$1", ['filter' => 'authPanitia']);
$routes->get('/panitia/verif_u/(:alphanum)', "Panitia::verif_u/$1", ['filter' => 'authPanitia']);
$routes->post('/panitia/verify/(:alphanum)', "Panitia::verify/$1", ['filter' => 'authPanitia']);
//panitia hasil
$routes->get('/panitia/hasil/(:alphanum)', "Panitia::hasil/$1", ['filter' => 'authPanitia']);
//panitia pemilih
$routes->get('/panitia/pemilih/(:alphanum)', "Panitia::pemilih/$1", ['filter' => 'authPanitia']);
$routes->get('/panitia/get_pemilih/(:alphanum)', "Panitia::get_pemilih/$1", ['filter' => 'authPanitia']);
$routes->post('/panitia/add_pemilih', "Panitia::add_pemilih", ['filter' => 'authPanitia']);
$routes->get('/panitia/delete_pemilih/(:alphanum)', "Panitia::delete_pemilih/$1", ['filter' => 'authPanitia']);
$routes->post('/panitia/271201delete_all_pemilih2601/(:alphanum)', "Panitia::delete_all_pemilih/$1", ['filter' => 'authPanitia']);
//admin 
$routes->get('/admin/masuk_v', 'Admin::masuk_v', ['filter' => 'authAdminLog']);
$routes->get('/admin/logout', 'Admin::logout');
//admin event
$routes->get('/admin/event', 'Admin::event', ['filter' => 'authAdmin']);
$routes->get('/admin/edit_event_v', 'Admin::edit_event_v', ['filter' => 'authAdmin']);
$routes->get('/admin/get_event', 'Admin::get_event', ['filter' => 'authAdmin']);
$routes->post('/admin/add_event', 'Admin::add_event', ['filter' => 'authAdmin']);
$routes->post('/admin/edit_event/(:alphanum)', 'Admin::edit_event/$1', ['filter' => 'authAdmin']);
$routes->get('/admin/delete_event/(:alphanum)', 'Admin::delete_event/$1', ['filter' => 'authAdmin']);
//admin panitia
$routes->get('/admin/panitia/(:alphanum)', 'Admin::panitia/$1', ['filter' => 'authAdmin']);
$routes->get('/admin/get_panitia/(:alphanum)', 'Admin::get_panitia/$1', ['filter' => 'authAdmin']);
$routes->post('/admin/add_panitia', 'Admin::add_panitia', ['filter' => 'authAdmin']);
$routes->get('/admin/get_panitia_edit/(:alphanum)', 'Admin::get_panitia_edit/$1', ['filter' => 'authAdmin']);
$routes->post('/admin/edit_panitia', 'Admin::edit_panitia', ['filter' => 'authAdmin']);
$routes->get('/admin/delete_panitia/(:alphanum)', 'Admin::delete_panitia/$1', ['filter' => 'authAdmin']);
//user
$routes->get('/admin/get_user/(:alphanum)', 'Admin::get_user/$1', ['filter' => 'authAdmin']);
/**
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
