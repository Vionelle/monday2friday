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
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

//PAGES
$routes->add('home', 'Home::index');
$routes->add('shop', 'Product::index');
$routes->add('about', 'About::index');

//Autentikasi,Login,Register
$routes->add('login', 'Auth::login');
$routes->add('lupa_password', 'Auth::forgotPassword');
$routes->add('reset_password', 'Auth::resetPassword');
$routes->add('register', 'Auth::register');    
$routes->add('logout', 'Auth::logout');
$routes->add('emailValidation/(:segment)', 'Auth::emailValidation/$1');

//TRANSAKSI
$routes->group('transaksi', ['filter' => 'auth'], function($routes){
    $routes->add('bayar/(:any)', 'Admin\Transaksi::bayar');
    $routes->add('batal/(:any)', 'Admin\Transaksi::batal');
    $routes->post('submitBayar/(:segment)', 'Admin\Transaksi::submitBayar/$1');
    $routes->post('submitCheckout', 'Admin\Transaksi::submitCheckout');
    $routes->add('user', 'Admin\Transaksi::user');
    $routes->add('invoice/(:segment)', 'Admin\Transaksi::invoice/$id_transaksi');
    $routes->add('selesai/(:segment)', 'Admin\Transaksi::selesai/$id_transaksi');
    
    //LACAK RESI
    $routes->add('lacakResi/(:segment)', 'Admin\Transaksi::lacakResi');
});

//PROFIL
$routes->group('profil', ['filter' => 'auth'], function($routes){
    $routes->get('user', 'User::index');
    $routes->get('edit', 'User::edit');
    $routes->post('update/(:segment)', 'User::update/$1');
});

// $routes->get('admin/cekPembayaran/(:segment)', 'Admin\Transaksi::cekPembayaran');
// $routes->post('admin/prosesProduk/(:segment)', 'Admin\Transaksi::prosesProduk');

/** CHECKING */
$routes->add('shop/cek', 'Product::cek');

//SHOP
$routes->group('shop', ['filter' => 'auth'], function($routes){
    $routes->add('keranjang', 'Product::viewCart');
    $routes->add('tambah', 'Product::tambah');
    $routes->add('delete/(:segment)', 'Product::delete');
    $routes->add('beli/(:any)', 'Product::buy');
    $routes->add('beli', 'Product::buy');
    $routes->add('provinsi', 'Product::getCity');
    $routes->add('biaya', 'Product::getCost');
    $routes->add('checkout', 'Product::checkout');
    $routes->add('transaksi/(:any)', 'Product::transaksi/$id');
});

$routes->add('admin/logout', 'Admin\Admin::adminLogout');

//ADMINISTRATOR
$routes->group('admin', ['filter' => 'noadmin'], function($routes){
    $routes->add('','Admin\Admin::adminLogin');
    $routes->add('login','Admin\Admin::adminLogin');
    $routes->add('lupapassword','Admin\Admin::adminForgotPassword');
    $routes->add('resetpassword','Admin\Admin::adminResetPassword');
});

$routes->group('admin', ['filter' => 'admin'], function($routes){
    $routes->add('sukses','Admin\Admin::adminSuccess');
    $routes->add('dashboard','Admin\Dashboard::home');
    $routes->add('listbarang','Admin\Dashboard::list');
    $routes->add('hasilcari','Admin\Dashboard::search');
    $routes->add('viewbarang','Admin\Dashboard::view');
    $routes->add('viewbarang/(:any)','Admin\Dashboard::view/$id');
    $routes->add('updatebarang/(:any)','Admin\Dashboard::update/$id');
    $routes->add('deletebarang/(:any)','Admin\Dashboard::delete/$id');
    $routes->add('tambahbarang','Admin\Dashboard::create');
    $routes->add('v_tambahbarang','Admin\Dashboard::viewCreate');
    $routes->add('daftaruser','Admin\Users::daftarUser');
    $routes->add('daftartransaksi','Admin\Transaksi::daftarTransaksi');
    $routes->add('viewtransaksi/(:any)','Admin\Transaksi::viewTransaksi/$id_transaksi');
    $routes->add('cekPembayaran/(:segment)','Admin\Transaksi::cekPembayaran');
    $routes->add('prosesProduk/(:segment)','Admin\Transaksi::prosesProduk');
    $routes->add('simpanResi/(:segment)','Admin\Transaksi::simpanResi');
    $routes->add('batal/(:segment)','Admin\Transaksi::batalAdmin');
    $routes->add('invoice/(:any)','Admin\Transaksi::invoice/$id_transaksi');
    $routes->add('laporan','Admin\Transaksi::laporan');
});

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
