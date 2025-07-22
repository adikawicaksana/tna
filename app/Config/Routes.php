<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::loginPost');
$routes->post('/refresh-token', 'Auth::refreshWebToken');
$routes->get('/logout', 'Auth::logout');
$routes->get('/register', 'Register::index');
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth:web,autologin']);



$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::registerPost');

$routes->group('api/v1', ['filter' => 'authjwt'], function($routes) {
    $routes->get('profile', 'Api\Profile::index');
});
$routes->post('api/v1/login', 'Api\Auth::login');
$routes->post('api/v1/logout', 'Api\Auth::logout');

$routes->post('api/fasyankes_check', 'register::postFasyankesCheck');


$routes->post('api/v1/token/refresh', 'Api\Auth::refreshToken');


