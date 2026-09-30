<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');
$routes->get('about', 'About::index');
$routes->get('services', 'Services::index');
$routes->match(['get', 'post'], 'contact', 'Contact::index');
$routes->get('register', 'Register::index');
$routes->post('register', 'Register::create');

$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

$routes->get('accounts', 'Accounts::index');
$routes->get('accounts/(:num)', 'Accounts::viewAccount/$1');
