<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/get', 'URLController::getAllShortlinks');
$routes->get('/get/(:segment)', 'URLController::getShortlink/$1');
$routes->post('/create', 'URLController::createShortlink', ['filters' => ['apiAuth', 'requestProtocol']]);
$routes->put('/update', 'URLController::updateShortlink', ['filters' => ['apiAuth', 'requestProtocol']]);
$routes->delete('/delete/(:segment)', 'URLController::deleteShortlink/$1', ['filters' => ['apiAuth', 'requestProtocol']]);
