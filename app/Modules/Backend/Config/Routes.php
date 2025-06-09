<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('/', ['namespace' => 'App\Modules\Backend\Controllers'], static function ($routes) {
    $routes->get('', 'AuthController::index', ['namespace' => 'App\Modules\Backend\Controllers']);
    $routes->get('auth', 'AuthController::index', ['namespace' => 'App\Modules\Backend\Controllers']);
    $routes->get('dd', 'AuthController::dd', ['namespace' => 'App\Modules\Backend\Controllers']);
});

$routes->group('blackhole', ['namespace' => 'App\Modules\Backend\Controllers'], static function ($routes) {
    $routes->post('in', 'AuthController::login');
    $routes->get('logout', 'AuthController::logout', ['filter' => 'auth']);
    $routes->post('settings', 'AuthController::settings', ['filter' => 'auth']);
    $routes->match(['POST', 'GET'], 'login-history', 'AuthController::loginHistory', ['filter' => 'auth']);
});

$routes->group('blackhole/dashboard', ['namespace' => 'App\Modules\Backend\Controllers'], static function ($routes) {
    $routes->match(['GET', 'POST'], '/', 'DashboardController::index', ['filter' => 'checkrole']);
});

$routes->group('blackhole/informasi-pedoman', ['namespace' => 'App\Modules\Backend\Controllers'], static function ($routes) {
    $routes->match(['GET', 'POST'], '/', 'InformationController::index', ['filter' => 'checkrole']);
});

$routes->group('blackhole/grup', ['namespace' => 'App\Modules\Backend\Controllers'], static function ($routes) {
    $routes->match(['GET','POST'], '/', 'UserGroupController::index', ['filter' => 'checkrole']);
    $routes->post('simpan', 'UserGroupController::save', ['filter' => 'checkrole']);
    $routes->post('hapus', 'UserGroupController::delete', ['filter' => 'checkrole']);
    $routes->get('fitur', 'UserGroupController::getFeatures', ['filter' => 'auth']);
    $routes->post('update-index', 'UserGroupController::updateIndex');
});

$routes->group('blackhole/akun', ['namespace' => 'App\Modules\Backend\Controllers'], static function ($routes) {
    $routes->match(['GET','POST'], '/', 'AccountController::index', ['filter' => 'checkrole']);
    $routes->post('simpan', 'AccountController::save', ['filter' => 'checkrole']);
    $routes->post('hapus', 'AccountController::delete', ['filter' => 'checkrole']);
});

$routes->match(['GET','POST'], 'blackhole/logs', 'LogController::index', ['filter' => 'checkrole']);

$routes->group('blackhole/kategori', ['namespace' => 'App\Modules\Backend\Controllers'], static function ($routes) {
    $routes->match(['GET','POST'], '/', 'CategoryController::index', ['filter' => 'checkrole']);
    $routes->post('simpan', 'CategoryController::save', ['filter' => 'checkrole']);
    $routes->post('hapus', 'CategoryController::delete', ['filter' => 'checkrole']);
    $routes->get('select2', 'CategoryController::select2', ['filter' => 'auth']);
});

$routes->group('blackhole/pengaturan-organisasi', ['namespace' => 'App\Modules\Backend\Controllers'], static function ($routes) {
    $routes->get('/', 'OrgSettingsController::index', ['filter' => 'checkrole']);
    $routes->post('simpan', 'OrgSettingsController::save', ['filter' => 'checkrole']);
});

$routes->group('blackhole/pengaturan-aplikasi', ['namespace' => 'App\Modules\Backend\Controllers'], static function ($routes) {
    $routes->get('/', 'SiteSettingsController::index', ['filter' => 'checkrole']);
    $routes->post('simpan', 'SiteSettingsController::save', ['filter' => 'checkrole']);
});

$routes->match(['GET', 'POST'], 'blackhole/dokumen/([a-z]+)', '\App\Modules\Backend\Controllers\DocumentController::index/$1', ['filter' => 'checkrole']);
$routes->post('blackhole/simpan-dokumen', '\App\Modules\Backend\Controllers\DocumentController::save', ['filter' => 'checkrole']);
$routes->post('blackhole/hapus-dokumen', '\App\Modules\Backend\Controllers\DocumentController::delete', ['filter' => 'checkrole']);

$routes->group('blackhole/file', ['namespace' => 'App\Modules\Backend\Controllers'], static function ($routes) {
    $routes->get('([0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12})', 'FileController::index/$1', ['filter' => 'auth']);
    $routes->head('([0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12})', 'FileController::index/$1', ['filter' => 'auth']);
    $routes->post('simpan', 'FileController::save', ['filter' => 'checkrole']);
    $routes->post('hapus', 'FileController::delete', ['filter' => 'checkrole']);
});