<?php
require('./vendor/autoload.php');

use App\Router\Router;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Router($_GET['url']);
$router->get('/', 'IndexController@show');

$router->run();
