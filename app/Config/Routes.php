<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/seeds', '\App\Controllers\Seeds::index');
$routes->get('error/([0-9]{3})', '\App\Controllers\Errors::index/$1');

$modulesPath = APPPATH . 'Modules/';
$modules = array_filter(glob($modulesPath . '*'), 'is_dir');

foreach ($modules as $module) {
    $routesPath = $module . '/Config/Routes.php';
    if (file_exists($routesPath)) {
        include $routesPath;
    }
}
