<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/get', 'URLController::getAllShortlinks');
$routes->get('/get/(:segment)', 'URLController::getShortlink/$1');
$routes->post('/create', 'URLController::createShortlink', ['filter' => 'apiAuth']);
$routes->put('/update', 'URLController::updateShortlink', ['filter' => 'apiAuth']);
$routes->delete('/delete/(:segment)', 'URLController::deleteShortlink/$1', ['filter' => 'apiAuth']);
