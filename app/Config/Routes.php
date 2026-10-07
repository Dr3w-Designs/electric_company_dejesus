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
$routes->post('logout', 'Auth::logout');

$routes->get('accounts', 'Accounts::index');
$routes->get('accounts/new', 'Accounts::newAccount');
$routes->post('accounts', 'Accounts::createAccount', ['filter' => 'csrf']);
$routes->get('accounts/(:num)/edit', 'Accounts::editAccount/$1');
$routes->put('accounts/(:num)', 'Accounts::updateAccount/$1', ['filter' => 'csrf']);
$routes->delete('accounts/(:num)', 'Accounts::deleteAccount/$1', ['filter' => 'csrf']);
$routes->get('accounts/(:num)', 'Accounts::viewAccount/$1');
