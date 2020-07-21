<?php
session_start();
require('./vendor/autoload.php');

use App\Router\Router;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Router($_GET['url']);


$router->get('/', 'IndexController@show', 'index');

$router->get('/admin', 'AdminController@index', 'admin.index');
$router->post('/admin', 'AdminController@login', 'admin.login');
$router->get('/admin/logout', 'AdminController@logout', 'admin.logout');

$router->get('/annuaire', 'AnnuaireController@index', 'annuaire');

$router->get('/support', 'SupportController@index', 'support.index');
$router->post('/support', 'SupportController@post', 'support.post');

$router->run();
